


function reload(){
      let last = null;

    setInterval(function() {
        $.ajax({
            url: window.location.href,
            cache: false,
            success: function(v) {
                if (last === null) {
                    last = v.trim();
                } else if (last !== v.trim()) {
                    location.reload();
                }
            }
        });
    }, 2000);
    }

    function LoginError() {
let modal = new bootstrap.Modal(document.getElementById('login'));
    modal.show();
}

// ================================== MENU ========================================

function openAddMenu() {
     const modal = new bootstrap.Modal(document.getElementById('addMenu'));
    modal.show();
}

function closeAddMenu() {
    const modal = document.getElementById('addMenu');
    document.getElementById('btnClose').onclick = () => modal.style.display = 'none';

    window.onclick = (e) => {
        if (e.target === modal) modal.style.display = 'none';
    };
}

$(document).ready(function () {

    $("#addMenuForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {

            if (res.success) {

                const menuGrid = document.getElementById('menuGrid');

                // HTML item baru
                const newItem = `
                    <div class="menu-card">
                        <div class="menu-img-wrapper">
                            <img src="/storage/${res.data.picture}" class="menu-img">
                        </div>

                        <div class="menu-body">
                            <h3 class="menu-title">${res.data.menuname}</h3>
                            <p class="menu-desc">${res.data.detail}</p>
                            <div class="menu-price">Rp ${Number(res.data.price).toLocaleString()}</div>

                            <div class="admin-actions">
                                <button type="button" class="btn-edit"
                                    onclick="openDetailMenu('${res.data.menuid}', '${res.data.menuname}', '${res.data.price}', '${res.data.detail}')">
                                    Action
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                menuGrid.insertAdjacentHTML('beforeend', newItem);

                // Tutup modal
                $("#addMenu").modal("hide");
            }
        });
    });
});



function openDetailMenu(menuid, menuname, price, detail) {

    document.getElementById('modalMenuId').value = menuid;
    document.getElementById('modalName').value   = menuname;
    document.getElementById('modalPrice').value  = price;
    document.getElementById('modalDetail').value = detail;

    const modalEl = document.getElementById('DetailMenu');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    document.getElementById('btnEdit').onclick = () => {
    const form = document.getElementById('editMenu');
    const formData = new FormData(form);

    fetch(`/savemenu/${menuid}`, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {

            // 🔥 Update UI tanpa reload
            const card = document.getElementById(`menuCard_${menuid}`);

            card.querySelector(".menu-img").src  = `/storage/${data.data.picture}`;
            card.querySelector(".menu-title").innerText = data.data.menuname;
            card.querySelector(".menu-desc").innerText  = data.data.detail;
            card.querySelector(".menu-price").innerText = 
                "Rp " + Number(data.data.price).toLocaleString();

            // Tutup modal
            bootstrap.Modal.getInstance(document.getElementById('DetailMenu')).hide();
        }
    });
};

document.getElementById('btnDelete').onclick = () => {
    if (confirm("Are you sure to delete this menu?")) {

        fetch(`/deletemenu/${menuid}`, { method: "GET" })
        .then(res => res.json())
        .then(data => {
            if (data.success) {

                // 🔥 Hapus elemen dari UI
                document.getElementById(`menuCard_${menuid}`).remove();

                // Tutup modal
                bootstrap.Modal.getInstance(document.getElementById('DetailMenu')).hide();
            }
        });
    }
};

}


function closeDetailMenu() {
    const modal = document.getElementById('DetailMenu');
    document.getElementById('btnClose').onclick = () => modal.style.display = 'none';

    window.onclick = (e) => {
        if (e.target === modal) modal.style.display = 'none';
    };
}

$(document).ready(function () {

    function loadMenu(search = "") {
        $.ajax({
            url: "/menu/search",
            type: "GET",
            data: { search: search },
            success: function (res) {

                let grid = $("#menuGrid");
                grid.empty();

                res.data.forEach(menu => {

                    let adminButtons = "";
                    let buyerButtons = "";

                    if (USER_LEVEL == 2) {
                        buyerButtons = `
                            <form class="addcart-form" action="/addcart" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="menuid" value="${menu.menuid}">
                                <input type="hidden" name="menuname" value="${menu.menuname}">
                                <input type="hidden" name="price" value="${menu.price}">
                                <button type="submit" class="btn-add-cart">
                                    <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                </button>
                            </form>
                        `;
                    }

                    if (USER_ROLE == 1) {
                        adminButtons = `
                            <div class="admin-actions">
                                <button type="button" class="btn-edit"
                                    onclick="openDetailMenu('${menu.menuid}', '${menu.menuname}', '${menu.price}', '${menu.detail}')">
                                    Detail
                                </button>
                            </div>
                        `;
                    }

                    grid.append(`
                        <div class="menu-card">
                            <div class="menu-img-wrapper">
                                <img src="/storage/${menu.picture}" class="menu-img">
                            </div>
                            <div class="menu-body">
                                <h3 class="menu-title">${menu.menuname}</h3>
                                <p class="menu-desc">${menu.detail}</p>
                                <div class="menu-price">Rp ${menu.price.toLocaleString()}</div>
                                
                                ${buyerButtons}
                                ${adminButtons}

                            </div>
                        </div>
                    `);

                });
            }
        });
    }

    // SEARCH tanpa refresh
    $("#btnSearch").on("click", function (e) {
        e.preventDefault();
        let keyword = $("#menuSearch").val();
        loadMenu(keyword);
    });

    // RESET tanpa refresh
    $("#btnReset").on("click", function (e) {
        e.preventDefault();
        $("#menuSearch").val("");
        loadMenu("");
    });

});



// =================================== PROMOTION ==============================================

function openAddPromotion() {
     const modal = new bootstrap.Modal(document.getElementById('AddPromotion'));
    modal.show();
}

function sortPromoCards() {
    const grid = document.querySelector('.promo-grid');
    if (!grid) return;

    // Ambil semua card
    let cards = Array.from(grid.querySelectorAll('.promo-card'));

    // Urut ASC berdasarkan atribut data-promotionname
    cards.sort((a, b) => {
        return a.dataset.promotionname.localeCompare(b.dataset.promotionname);
    });

    // Hapus semua dulu
    grid.innerHTML = "";

    // Pasang kembali hasil sorting
    cards.forEach(card => grid.appendChild(card));
}


$(document).ready(function () {

    $("#addPromotionForm").on("submit", function (e) {
        e.preventDefault(); // cegah reload

        $.ajax({
            url: "/savepromotions",
            type: "POST",
            data: $(this).serialize(),
 success: function (promo) {

    let modal = bootstrap.Modal.getInstance(
        document.getElementById("AddPromotion")
    );
    modal.hide();                 // ❗ Tutup modal dulu

    appendPromoCard(promo);       // Tambah card
    sortPromoCards();             // Baru sort

    $("#addPromotionForm")[0].reset();
},

            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Gagal menyimpan promo!");
            }
        });

    });

});
function appendPromoCard(promo) {
    let html = `
        <div class="promo-card" data-promotionname="${promo.promotionname}">
            <h5>${promo.promotionname}</h5>

            <ul class="menu-list">
                ${promo.menus.map(m => `
                    <li class="menu-item">${m.name} — Rp ${new Intl.NumberFormat("id-ID").format(m.price)}</li>
                `).join('')}
            </ul>

            <div class="divider"></div>

            <div class="promo-total">
                <span>Total:</span>
                <span>Rp ${new Intl.NumberFormat("id-ID").format(promo.total)}</span>
            </div>
    `;

    // Jika levelid = 2 (user)
    if (window.levelid == 2) {
        html += `
            <form action="/addcart" method="POST" class="promo-actions">
                <input type="hidden" name="_token" value="${window.csrf}">
                <input type="hidden" name="menuname" value="${promo.promotionname}">
                <input type="hidden" name="promotionname" value="${promo.promotionname}">
                <input type="hidden" name="price" value="${promo.total}">
                <button type="submit" class="btn-add-cart">Add to Cart</button>
            </form>
        `;
    }

    // Jika levelid = 1 (admin)
    if (window.levelid == 1) {
        html += `
            <div class="promo-actions">
                <button
                    class="btn-edit"
                    onclick='openDetailPromotion("${promo.promotionid}", "${promo.promotionname}", ${JSON.stringify(promo.menus)})'>
                    Detail
                </button>
            </div>
        `;
    }

    html += `</div>`;

    $(".promo-grid").prepend(html);
}

function openDetailPromotion(promotionId, promotionName, promoPrices) {
    // 🔥 Set promotion name
    document.getElementById('detailPromotionName').value = promotionName;

    // SET VALUE
console.log("promoPrices:", promoPrices); // cek di console

document.querySelectorAll('input[data-menuid]').forEach(input => {
    const menuid = input.getAttribute('data-menuid');

    const value =
        promoPrices[menuid] ??
        promoPrices[Number(menuid)] ??
        "";

    input.value = value;
});


    // SET FORM ACTION
    const form = document.getElementById('detailPromotionForm');
    form.action = `/savepromotion/${promotionName}`;

form.onsubmit = function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.action, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" }
    })
    .then(res => res.json())
.then(data => {

    const card = document.getElementById(`promoCard_${promotionId}`);
    if (card) {

        // Update nama promo
        card.querySelector('.promo-title').textContent = data.promotionname;

        // Update data attribute
        card.dataset.promotionname = data.promotionname;

        // 🔥 Update daftar menu
        const ul = card.querySelector('.menu-list');
        ul.innerHTML = ""; // kosongkan

        data.menus.forEach(menu => {
            const li = document.createElement("li");
            li.classList.add("menu-item");
            li.textContent = `${menu.name} — Rp ${menu.price.toLocaleString("id-ID")}`;
            ul.appendChild(li);
        });

        // 🔥 Update total
        const totalEl = card.querySelector('.promo-total span:last-child');
        totalEl.textContent = `Rp ${data.total.toLocaleString("id-ID")}`;
        // 🔥 Update tombol detail (biar pakai data terbaru)
        const btn = card.querySelector(".btn-edit");
        if (btn) {
            btn.setAttribute(
                "onclick",
                `openDetailPromotion("${promotionId}", "${data.promotionname}", ${JSON.stringify(data.prices)})`
                );
        }

    }
    sortPromoCards();

    // Tutup modal
    bootstrap.Modal.getInstance(document.getElementById('DetailPromotion')).hide();
});

};

// DELETE PROMOTION
document.getElementById('btnDeletePromotion').onclick = function () {

    if (!confirm("Yakin ingin menghapus promotion ini?")) return;

    fetch(`/deletepromotion/${promotionName}`, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value
        }
    })
    .then(res => res.json())
    .then(data => {

        // 🔥 Hapus card dari daftar tanpa reload
        const card = document.getElementById(`promoCard_${promotionId}`);
        if (card) card.remove();

        // Tutup modal
        bootstrap.Modal.getInstance(document.getElementById('DetailPromotion')).hide();
    })
    .catch(err => console.error("Delete error:", err));
};
    

    const modal = new bootstrap.Modal(document.getElementById('DetailPromotion'));
    modal.show();
}

// =================================== CART ============================================
function check(){
    document.getElementById('selectAll').addEventListener('change', function() {
  const checked = this.checked;
  document.querySelectorAll('.itemCheckbox').forEach(cb => cb.checked = checked);
});
}

function addModal(){
    document.getElementById('formModal').style.display="flex";
}

document.addEventListener("DOMContentLoaded", function () {
    
    const cartCountEl = document.getElementById("Cart");

    // ambil semua form Add to Cart
    document.querySelectorAll(".addcart-form").forEach(form => {
        
        form.addEventListener("submit", async function (e) {
            e.preventDefault(); // cegah reload

            let formData = new FormData(form);

            const response = await fetch("/addcart", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const result = await response.json();

            if (result.success) {
                // update UI jumlah cart
                cartCountEl.textContent = result.count;

                // efek kecil biar hidup
                cartCountEl.style.transform = "scale(1.3)";
                setTimeout(() => {
                    cartCountEl.style.transform = "scale(1)";
                }, 150);
            } else {
                alert("Gagal menambah ke keranjang.");
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    
    const cartCountEl = document.getElementById("Cart");

    // ambil semua form Add to Cart
    document.querySelectorAll(".promo-actions").forEach(form => {
        
        form.addEventListener("submit", async function (e) {
            e.preventDefault(); // cegah reload

            let formData = new FormData(form);

            const response = await fetch("/addcart", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            const result = await response.json();

            if (result.success) {
                // update UI jumlah cart
                cartCountEl.textContent = result.count;

                // efek kecil biar hidup
                cartCountEl.style.transform = "scale(1.3)";
                setTimeout(() => {
                    cartCountEl.style.transform = "scale(1)";
                }, 150);
            } else {
                alert("Gagal menambah ke keranjang.");
            }
        });
    });
});

function updateCartUI(count){
    // Sesuaikan dengan elemen keranjang /
    let cartIcon = document.getElementById("cart_count");

    if(cartIcon){
        cartIcon.textContent = count;
    }
}

// ================================= Nampil History =======================================
function showInvoiceModal(id) {
    fetch('/detailhistory/' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('invoiceContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('invoiceModal')).show();
        })
        .catch(err => {
            document.getElementById('invoiceContent').innerHTML =
                "<div class='p-3 text-danger'>Error loading invoice...</div>";
        });
}


// ================================= USER DATA =============================================

$(document).ready(function () {

    $(".sort-btn").on("click", function (e) {
        e.preventDefault();

        let orderBy = $(this).data("order");
        let sort = $(this).data("sort");

        $.ajax({
            url: "/userdata/search",
            type: "GET",
            data: {
                order_by: orderBy,
                sort: sort
            },
            success: function (res) {

                let grid = $(".user-grid");
                grid.empty();

                res.data.forEach(user => {
                    grid.append(`
                        <div class="user-card">
                            <div class="user-card-header">
                                ${user.levelname}
                            </div>

                            <div class="user-card-body">

                                <div class="info-group">
                                    <div class="info-label">Username</div>
                                    <div class="info-value">${user.username}</div>
                                </div>

                                <div class="info-group">
                                    <div class="info-label">Role</div>
                                    <div class="info-value">${user.rolename}</div>
                                </div>

                                <div class="info-group">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">${user.email}</div>
                                </div>

                                <div class="info-group">
                                    <div class="info-label">Phone Number</div>
                                    <div class="info-value">${user.phonenumber}</div>
                                </div>

                                <div class="user-actions">
                                    <form action="/resetpassword/${user.userid}" method="post" class="d-inline" style="flex:1; min-width:130px;">
                                        <button type="submit" class="btn-reset">Reset Password</button>
                                    </form>

                                    <a href="/deleteuser/${user.userid}" class="btn-delete" style="flex:1; min-width:130px;">
                                        Delete User
                                    </a>
                                </div>

                            </div>
                        </div>
                    `);
                });
            }
        });
    });
});


$(document).ready(function () {

    // Fungsi untuk render ulang grid
    function renderGrid(data) {
        let grid = $(".user-grid");
        grid.empty();

        data.forEach(user => {
            grid.append(`
                <div class="user-card">
                    <div class="user-card-header">${user.levelname}</div>

                    <div class="user-card-body">

                        <div class="info-group">
                            <div class="info-label">Username</div>
                            <div class="info-value">${user.username}</div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Role</div>
                            <div class="info-value">${user.rolename}</div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value">${user.email}</div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">${user.phonenumber}</div>
                        </div>

                        <div class="user-actions">
                            <a href="/resetpassword/${user.userid}" class="btn-reset">Reset Password</a>
                            <a href="/deleteuser/${user.userid}" class="btn-delete">Delete User</a>
                        </div>

                    </div>
                </div>
            `);
        });
    }

    // ================= SEARCH AJAX =====================
    $("#searchForm").on("submit", function (e) {
        e.preventDefault();

        let keyword = $("#searchInput").val();

        $.ajax({
            url: "/userdata/search",
            type: "GET",
            data: { search: keyword },
            success: function (res) {
                renderGrid(res.data);
            }
        });
    });

    // ================= RESET AJAX =====================
    $("#resetBtn").on("click", function () {

        $("#searchInput").val(""); // kosongkan input

        $.ajax({
            url: "/userdata/search",
            type: "GET",
            success: function (res) {
                renderGrid(res.data);
            }
        });
    });

});


// ======================================= COURIER ORDER =================================
document.addEventListener("DOMContentLoaded", () => {

    let forms = document.querySelectorAll(".update-form");

    console.log("Jumlah form ditemukan:", forms.length);

    forms.forEach(form => {

        form.addEventListener("submit", function(e){
            e.preventDefault();

            let url = form.action;
            let formData = new FormData(form);

            fetch(url, {
                method: "POST",
                body: formData
            })
            .then(r => r.json())
            .then(res => {

                if(res.success){

                    // update badge status
                    let row = form.closest("tr");
                    let badge = row.querySelector(".status-badge");
                    let newStatus = formData.get("status");

                    badge.textContent = newStatus.replace("_", " ");
                    badge.className = "status-badge " + newStatus;

                    // highlight select
                    let select = form.querySelector(".status-select");
                    select.style.background = "#d4edda";
                    setTimeout(() => select.style.background = "", 600);
                }

            })
            .catch(err => console.error(err));
        });

    });

});

// ================================= MONTHLY REPORT ========================================

document.addEventListener("DOMContentLoaded", () => {
    const filterForm = document.getElementById("filterForm");
    if (!filterForm) return; // cegah error

    filterForm.addEventListener("submit", function(e) {
        e.preventDefault();

        // Redirect manual (supaya pakai /report)
        const params = new URLSearchParams(new FormData(filterForm)).toString();
        window.location.href = "/report?" + params;
    });

    const sortBtn = document.getElementById("sortBtn");
    if (sortBtn) {
        sortBtn.addEventListener("click", function(e) {
            e.preventDefault();

            const sort = this.dataset.sort;
            const params = new URLSearchParams(new FormData(filterForm));
            params.set("sort", sort);

            window.location.href = "/report?" + params.toString();
        });
    }
});



// 🔥 Fungsi AJAX utama
function loadReport(url) {
    fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
        .then(res => res.text())
        .then(html => {
            document.getElementById("reportTable").innerHTML = html;
        });
}

// ====================================== DAILY REPORT =============================