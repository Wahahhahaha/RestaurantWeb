<?php

namespace App\Http\Controllers;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use session;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Elibyy\TCPDF\Facades\TCPDF;
use App\Exports\UserTransactionExport;
use Illuminate\Support\Facades\DB;


class Ctrl extends Controller
{
    public function regis(){
        echo view ('header');
        echo view('register');
    }

    public function registact(Request $request){
        $apple = new Table();
        $hola=[
            'username'=>$request->input('u'),
            'password'=>Hash::make($request->input('p')),
            'levelid'=>2]; 
        $userid = $apple->regis('user',$hola);

        $halo = [
            'userid'      => $userid,
            'name'      => $request->input('u'),
            'email'       => $request->input('e'),
            'phonenumber' => $request->input('t')
        ];

        $apple->regis('buyer',$halo);
        return redirect('/login');
    }

    public function login(){
        echo view ('header');
        echo view('login');
    }

    public function loginact(Request $request){
        $user = $request->input('u');
        $pass = $request->input('p');

        $apple = new Table();

        $table1 = 'user';
        $table2 = 'buyer';
        $table3 = 'employer';

        $on   = ['user.userid', '=', 'buyer.userid'];
        $on2  = ['user.userid', '=', 'employer.userid'];
        $where = ['user.username' => $user];

        $data = $apple->login($table1, $table2, $table3, $where, $on, $on2);

        if ($data && Hash::check($pass, $data->password)) {

            $request->session()->put('userid', $data->userid ?? null);
            $request->session()->put('username', $data->username ?? null);
            $request->session()->put('levelid', $data->levelid ?? null);
            $request->session()->put('roleid', $data->roleid ?? null);

        if (!empty($data->roleid)) {
            $request->session()->put('roleid', $data->roleid);
        } else {
            $request->session()->put('roleid', 3); 
        }

        if ($data->roleid == 2) {
            $request->session()->put('courierid', $data->employerid);
        }

        return redirect('/home');

        } else {
            return redirect('/login')->with('error', 'Username or password wrong!');
        }
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect ('/home');
    }

    public function home(Request $request){
        $apple = new Table();
        $banana ['menu'] = $apple->show('menu');
        echo view ('header');
        echo view ('menu');
        echo view ('home', $banana);
        echo view ('footer');
    }
public function profile(Request $request){
    if (session('userid') > 0) {
        $userid = $request->session()->get('userid');

        $data = DB::table('user')
            ->leftJoin('buyer', 'user.userid', '=', 'buyer.userid')
            ->leftJoin('employer', 'user.userid', '=', 'employer.userid')
            ->select(
                'user.userid',
                'user.username',
                DB::raw('COALESCE(buyer.email, employer.email) as email'),
                DB::raw('COALESCE(buyer.phonenumber, employer.phonenumber) as phonenumber')
            )
            ->where('user.userid', $userid)
            ->first();

        echo view('header');
        echo view('profile', ['data' => $data]);
    } else {
        return redirect('login');
    }
}

    public function edituser($id){
        if (session ('userid')>0) {
        $apple = new Table();
        $baby = "edit"; 

        $table='user';
        $table2='buyer';
        $table3='employer';
            $on=['user.userid','=','buyer.userid'];
            $on1=['user.userid','=','employer.userid'];
        $where = ['user.userid' => $id];

        $datas = $apple->joinwhere($table,$table2,$table3,$on,$on1,$where);
        echo view ('header');
        echo view('inputprofile',compact('baby','datas'));
        echo view('footer');
        }else{
            return redirect('login');
        }
    }

    public function updateuser(Request $request,$id){
        if (session ('userid')>0) {
        $apple = new Table();
        $pine = ['userid' => $id];

        $userData = [
            'username' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ];
        $apple->edit('user', $pine, $userData);

        $userrData = [
            'email' => $request->input('email'),
            'phonenumber' => $request->input('phonenumber'),
        ];
        $apple->edit('buyer', $pine, $userrData);

        $apple->edit('employer', $pine, $userrData);

        return redirect('/profile');
        }else{
            return redirect('login');
        }
    }

    public function resetpass(Request $request,$id){
        $apple = new Table();
        $pine = ['userid' => $id];

        $hola=array('password'=>Hash::make('12345'));

        $banana= $apple->edit('user',$pine,$hola);
        return redirect('/userdata');
    }

    public function historytransaction(Request $request){
         if (session('userid') > 0) {
         $query = DB::table('order')
            ->where('userid', session('userid'));

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('orderdate', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('orderdate', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('orderdate', '<=', $request->date_to);
        }

        $data = $query->orderBy('orderdate', 'desc')->paginate(10);
        $data->appends($request->all());

        echo view('header');
        echo view('menu');
        echo view('history', compact('data'));
        echo view('footer');
        } else {
            return redirect('login');
        }
    }

    public function historydetail($id){
        if (session('userid') > 0) {

        $order = DB::table('detail')
            ->join('order', 'detail.orderid', '=', 'order.orderid')
            ->leftJoin('user', 'order.courierid', '=', 'user.userid')
            ->leftJoin('buyer', 'order.userid', '=', 'buyer.userid')
            ->select(
                'order.orderid',
                'buyer.name as buyer_name',
                'user.username as courier_name',
                'order.orderdate',
                'order.address'
            )
            ->where('order.orderid', $id)
            ->first();

        if (!$order) {
            return "Order data with ID $id not found!.";
        }

        $normalItems = DB::table('detail')
            ->join('menu', 'detail.menuid', '=', 'menu.menuid')
            ->where('detail.orderid', $id)
            ->select(
                'menu.menuname',
                'detail.orderpcs',
                'detail.pcsprice',
                DB::raw('(detail.orderpcs * detail.pcsprice) as totalprice')
            )
            ->get();

        $promoItems = DB::table('detail')
            ->join('promotion', 'detail.promotionid', '=', 'promotion.promotionid')
            ->join('promotion as p2', 'promotion.promotionname', '=', 'p2.promotionname')
            ->where('detail.orderid', $id)
            ->groupBy('promotion.promotionname')
            ->select(
                DB::raw('CONCAT("Promo - ", promotion.promotionname) as menuname'),
                DB::raw('1 as orderpcs'),
                DB::raw('SUM(p2.prices) as pcsprice'),
                DB::raw('SUM(p2.prices) as totalprice')
            )
            ->get();

            $details = $normalItems->concat($promoItems);
            echo view('detailhistory', compact('order', 'details'));
        } else {
            return redirect('/login');
        }
    }

    public function promotion(){
        $promos = DB::table('promotion')
            ->join('menu', 'promotion.menuid', '=', 'menu.menuid')
            ->select(
                'promotion.promotionid',
                'promotion.promotionname',
                'menu.menuname',
                'promotion.prices'
            )
            ->orderBy('promotion.promotionname')
            ->get();

        $grouped = [];
        foreach ($promos as $promo) {
        $cat = $promo->promotionname;

        if (!isset($grouped[$cat])) {
            $grouped[$cat] = [
                'promotionid' => $promo->promotionid,
                'promotionname' => $promo->promotionname,
                'menus' => [],
                'total' => 0
            ];
        }
        $grouped[$cat]['menus'][] = [
            'name' => $promo->menuname,
            'price' => $promo->prices
        ];

        $grouped[$cat]['total'] += $promo->prices;
    }

        echo view('header');
        echo view('menu');
        echo view('promotion', ['promotions' => $grouped]);
    }

   public function addpromo() {
        $baby = "input";
        $menu = null;
        $apple = new Table();
        $ban = $apple->show('menu');
        $categories = $apple->show('promotion'); 

        echo view('header');
        echo view('inputpromotion', compact('baby', 'menu', 'ban', 'categories'));
        echo view('footer');
        }

    public function editpromo($name) {
        $apple = new Table();
        $baby = "edit";

        $promos = $apple->wheres('promotion', ['promotionname' => $name]);

        if ($promos instanceof \Illuminate\Support\Collection) {
            $promos = $promos->toArray();
        }

        if (is_object($promos)) {
            $promos = [$promos];
        }


        $menu = !empty($promos) ? (object)$promos[0] : null;

        if (!$menu) {
            return redirect('/promotions')->with('error', 'Promotion not found.');
        }

        $ban = $apple->show('menu');

        echo view('header');
        echo view('inputpromotion', compact('baby', 'menu', 'ban', 'promos'));
        echo view('footer');
    }



    public function savepromo(Request $request, $id){
        $apple = new Table();
        $promotionname = $request->input('promotionname'); 
        $prices = $request->input('prices'); 

        if (!$promotionname) {
            return back()->with('error', 'Promotion name is required.');
        }

        if ($id && $id != 0) {
            $apple->remove('promotion', ['promotionname' => $promotionname]);
        }

        foreach ($prices as $menuid => $price) {
            if ($price != null && $price > 0) {
                $apple->add('promotion', [
                    'promotionname' => $promotionname,
                    'menuid' => $menuid,
                    'prices' => $price,
                ]);
            }
        }
        return redirect('/promotions')->with('success', 'Promotion saved successfully!');
    }

    public function deletepromo($name) {
        $apple = new Table();
        $ws=array('promotionname'=>$name);
        $bans = $apple->remove('promotion',$ws);
        return redirect('/promotions');
    }

    public function cart(Request $request){
        if (session('userid') > 0) {
       $cart = session()->get('cart', []);

        echo view('header');
        echo view('cart',  compact('cart'));
        } else {
            return redirect('login');
        }
    }

    public function store(Request $request){
        if (session('userid') > 0) {
        $menuid = $request->input('menuid');
        $menuname = $request->input('menuname');
        $price = $request->input('price');
        $categoryid = $request->input('promotionid');
        $categoryname = $request->input('promotionname');

        $cart = session()->get('cart', []);

        if ($categoryid && $categoryname) {
            $key = "promo_" . $categoryid; 
            if (isset($cart[$key])) {
                $cart[$key]['quantity']++;
            } else {
                $cart[$key] = [
                    'menuname' => $categoryname,
                    'price' => $price,
                    'quantity' => 1,
                    'promotionid' => $categoryid,
                    'promotionname' => $categoryname,
                    'type' => 'promo'
                ];
            }

        } else {
            if (isset($cart[$menuid])) {
                $cart[$menuid]['quantity']++;
            } else {
                $cart[$menuid] = [
                    'menuname' => $menuname,
                    'price' => $price,
                    'quantity' => 1,
                    'type' => 'menu'
                ];
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Successfully add menu!');
        }else{
            return redirect();
        }
    }

    public function remove($id){
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Deleted an item!');
    }

    public function checkout(Request $request){
        if (session ('userid')>0) {
         $selected = $request->input('selected', []);
        $cart = session()->get('cart', []);

        if (empty($selected)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 item untuk checkout!');
        }

        $checkoutItems = array_filter($cart, function ($key) use ($selected) {
            return in_array($key, $selected);
        }, ARRAY_FILTER_USE_KEY);

        session()->put('checkout_items', $checkoutItems);

        echo view('header');
        echo view('checkout', ['items' => $checkoutItems]);
        }else{
            return redirect ('login');
        }
    }

    public function pay(Request $request){
        $checkoutItems = session()->get('checkout_items', []);

        if (empty($checkoutItems)) {
            return redirect()->back()->with('error', 'Tidak ada item untuk dibayar.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($checkoutItems as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $orderId = DB::table('order')->insertGetId([
                'userid'      => session('userid'),
                'ordersource' => 'online',
                'orderdate'   => now(),
                'address'     => $request->input('a'),
                'total'       => $total,
                'note'        => $request->input('note'),
                'status'      => 'Pending'
            ]);

            foreach ($checkoutItems as $id => $item) {
                $isPromo = isset($item['type']) && $item['type'] === 'promo';

                DB::table('detail')->insert([
                    'orderid'     => $orderId,
                    'menuid'      => $isPromo ? null : (int) $id,
                    'promotionid' => $isPromo ? ($item['promotionid'] ?? null) : null,
                    'orderpcs'    => $item['quantity'],
                    'pcsprice'    => $item['price'],
                    'totalprice'  => $item['price'] * $item['quantity'],
                ]);
            }

            DB::table('payment')->insert([
                'orderid'     => $orderId,
                'paymentdate' => now(),
                'method'      => $request->method,
                'total'       => $total
            ]);

            $courier = DB::table('employer')
                ->where('roleid', 2)
                ->inRandomOrder()
                ->first();

            if ($courier) {
                DB::table('order')
                    ->where('orderid', $orderId)
                    ->update([
                        'courierid' => $courier->employerid,
                        'status'    => 'pickup_assigned',
                    ]);
            }

            DB::commit();

            session()->forget('checkout_items');

            $cart = session()->get('cart', []);
            foreach ($checkoutItems as $id => $item) {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);

            return redirect('/home')->with('success', 'Pembayaran berhasil dan kurir otomatis diassign! 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function menudata(Request $request){
         if (session('userid') > 0) {
        $query = DB::table('menu');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('menu.menuname', 'like', "%$search%");
        }

        $banana['data'] = $query->paginate(15);

        echo view('header');
        echo view('menu');
        echo view('menudata', $banana);
        echo view('footer');
        } else {
            return redirect('login');
        }
    }

    public function inputmenu($id = null){
        $baby = "input";
        $menu = null;   

        echo view('header');
        echo view('inputmenu',compact('baby','menu'));
        echo view('footer');
    }

    public function editmenu($id){
        $apple = new Table();
        $baby = "edit"; 
        $key = ['menuid' => $id];
        $menu = $apple->where('menu',$key);
        echo view('header');
        echo view('inputmenu',compact('baby','menu'));
        echo view('footer');
    }

    public function savemenu(Request $request, $id){
        $apple = new Table();
        $pine = ['menuid' => $id];
        $old = $apple->where('menu', $pine);

        if ($request->hasFile('pic')) {
            $paths = $request->file('pic')->store('uploads', 'public');
        } else {
            $paths = $old->picture ?? '';
        }

        $holas = [
            'picture' => $paths,
            'menuname' => $request->input('n'),
            'price' => $request->input('p'),
            'detail' => $request->input('d')
        ];

        if ($id && $id != 0) {
            $apple->edit('menu', $pine, $holas);
        } else {
            $apple->add('menu', $holas);
        }
        return redirect('/menu');
    }

    public function deletemenu($id){
        $apple= new Table();
        $ws=array('menuid'=>$id);
        $bans = $apple->remove('menu',$ws);
        return redirect('/menu');
    }

    public function userdata(Request $request){
        if (session('userid') > 0) {

            $query = DB::table('user')
                ->leftJoin('level', 'user.levelid', '=', 'level.levelid')
                ->leftJoin('employer', 'user.userid', '=', 'employer.userid')
                ->leftJoin('role as role_emp', 'employer.roleid', '=', 'role_emp.roleid')
                ->leftJoin('buyer', 'user.userid', '=', 'buyer.userid')
                ->select(
                    'user.userid',
                    'user.username',
                    'level.levelname',
                    DB::raw("COALESCE(role_emp.rolename, 'Buyer') AS rolename"),
                    DB::raw('COALESCE(employer.email, buyer.email) AS email'),
                    DB::raw('COALESCE(employer.phonenumber, buyer.phonenumber) AS phonenumber')
                );

        if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('user.username', 'like', "%$search%")
              ->orWhere('employer.email', 'like', "%$search%")
              ->orWhere('buyer.email', 'like', "%$search%")
              ->orWhere('employer.phonenumber', 'like', "%$search%")
              ->orWhere('buyer.phonenumber', 'like', "%$search%")
              ->orWhere('level.levelname', 'like', "%$search%")
              ->orWhere('role_emp.rolename', 'like', "%$search%");

            if (stripos($search, 'buyer') !== false) {
                $q->orWhereNotNull('buyer.userid');
            }
        });
        }

            $allowedSortColumns = [
                'user.userid' => 'user.userid',
                'user.username' => 'user.username',
                'level.levelname' => 'level.levelname'
            ];

            $orderBy = $request->input('order_by', 'user.userid');
            if (!array_key_exists($orderBy, $allowedSortColumns)) {
                $orderBy = 'user.userid';
            }

            $sort = strtolower($request->input('sort', 'asc')) === 'desc' ? 'desc' : 'asc';
            $query->orderBy($allowedSortColumns[$orderBy], $sort);

            $perPage = 10;
            $lope = $query->paginate($perPage)
                ->appends($request->only(['username', 'order_by', 'sort']));

            echo view('header');
            echo view('menu');
            echo view('userdata', ['lope' => $lope]);
            echo view('footer');
        } else {
            return redirect('/login');
        }
    }

    public function deleteuser($id){
        $apple= new Table();
        $w=array('userid'=>$id);
        $ban = $apple->remove('user',$w);

        $bans = $apple->remove('buyer',$w);
        return redirect('/userdata');
    }

   public function report(Request $request)
{
    if (session('userid') > 0) {
        $data = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->selectRaw('MONTH(orderdate) as bulan, YEAR(orderdate) as tahun, MAX(orderdate) as tanggal')
            ->groupBy('bulan', 'tahun')
            ->get();

        $bulanTahun = collect($data)
            ->unique(fn($item) => $item->bulan . '-' . $item->tahun)
            ->values();

        if ($request->filled('date_from') || $request->filled('date_to')) {
            $dateFrom = $request->input('date_from', '0000-00-00');
            $dateTo = $request->input('date_to', now()->format('Y-m-d'));

            $bulanTahun = $bulanTahun->filter(fn($item) =>
                $item->tanggal >= $dateFrom && $item->tanggal <= $dateTo
            );
        }

        $sort = $request->input('sort', 'desc');
        $bulanTahun = $sort === 'asc'
            ? $bulanTahun->sortBy(fn($item) => $item->tahun . str_pad($item->bulan, 2, '0', STR_PAD_LEFT))->values()
            : $bulanTahun->sortByDesc(fn($item) => $item->tahun . str_pad($item->bulan, 2, '0', STR_PAD_LEFT))->values();

        echo view('header');
        echo view('menu');
        echo view('report', [
            'bulanTahun' => $bulanTahun,
            'sort' => $sort
        ]);
        echo view('footer');
    } else {
        return redirect('/login');
    }
}

    public function monthreport(Request $request){ 
        $bulan = $request->input('bulan', date('m')); 
        $tahun = $request->input('tahun', date('Y')); 

        $pemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->sum('total');

        $pengeluaran = DB::table('expense')->sum('total'); 

        $laba = $pemasukan - $pengeluaran; 

        $detailPemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->get();
        $detailPengeluaran = DB::table('expense')->get();

        echo view('header'); 
        echo view('monthlyreport', compact(
            'bulan', 'tahun', 'pemasukan', 'pengeluaran', 'laba', 'detailPemasukan', 'detailPengeluaran'
        )); 
    }

    public function pdfmonth(Request $request){
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $pemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->sum('total');

        $pengeluaran = DB::table('expense')->sum('total');

        $laba = $pemasukan - $pengeluaran;

        $detailPemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->get();

        $detailPengeluaran = DB::table('expense')->get();

        $html = view('monthlyreport', compact(
            'bulan', 'tahun', 'pemasukan', 'pengeluaran', 'laba', 'detailPemasukan', 'detailPengeluaran'
        ))->render();

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('HappyDining');
        $pdf->SetAuthor('HappyDining');
        $pdf->SetTitle('Laporan Keuangan Bulan ' . $bulan . ' Tahun ' . $tahun);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        $filename = 'Laporan_Keuangan_' . $bulan . '_' . $tahun . '.pdf';
        $pdf->Output($filename, 'I');
    }


    public function excelmonth(Request $request){
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $pemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->sum('total');

        $pengeluaran = DB::table('expense')->sum('total');

        $laba = $pemasukan - $pengeluaran;

        $detailPemasukan = DB::table('order')
            ->whereIn('status', ['Paid', 'delivered'])
            ->whereMonth('orderdate', $bulan)
            ->whereYear('orderdate', $tahun)
            ->get();

        $detailPengeluaran = DB::table('expense')
            ->select('expensename', 'total')
            ->get();

        $data = [
            ['Laporan Keuangan Bulan ' . $bulan . ' Tahun ' . $tahun],
            [],
            ['Pemasukan'],
            ['Tanggal', 'Keterangan', 'Jumlah (Rp)'],
        ];

        foreach ($detailPemasukan as $p) {
            $data[] = [
                \Carbon\Carbon::parse($p->orderdate)->format('d-m-Y H:i'),
                'Penjualan #' . $p->orderid,
                $p->total,
            ];
        }

        $data[] = ['', 'Total Pemasukan', $pemasukan];
        $data[] = [];
        $data[] = ['Pengeluaran'];
        $data[] = ['Nama Pengeluaran', 'Jumlah (Rp)'];

        foreach ($detailPengeluaran as $e) {
            $data[] = [
                $e->expensename,
                $e->total,
            ];
        }

        $data[] = ['', 'Total Pengeluaran', $pengeluaran];
        $data[] = [];
        $data[] = ['Laba Bersih', '', $laba];
        $data[] = [];
        $data[] = ['', '', 'Tanggal Cetak: ' . date('d-m-Y H:i')];

        return Excel::download(new class($data) implements FromArray, WithStyles {
            private $data;
            public function __construct($data) { $this->data = $data; }

            public function array(): array {
                return $this->data;
            }

            public function styles(Worksheet $sheet)
            {
                $sheet->mergeCells('A1:C1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                foreach (['A3', 'A8', 'A15'] as $cell) {
                    if ($sheet->getCell($cell)->getValue()) {
                        $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(12);
                    }
                }

                foreach (range('A', 'C') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:C{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                return [];
            }
        }, 'Financial_report_' . $bulan . '_' . $tahun . '.xlsx');
    }

    public function daily(Request $request){
        if (session('userid') > 0) {

            // Ambil hanya tanggal dari order yang Paid atau delivered
            $tanggalPemasukan = DB::table('order')
                ->whereIn('status', ['Paid', 'delivered'])
                ->select(DB::raw('DATE(orderdate) as tanggal'))
                ->groupBy(DB::raw('DATE(orderdate)'))
                ->pluck('tanggal')
                ->toArray();

            $tanggalSemua = collect($tanggalPemasukan)
                ->unique()
                ->sort()
                ->values();

            // Filter rentang tanggal bila diisi
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $tanggalSemua = $tanggalSemua->filter(fn($tgl) =>
                    $tgl >= $request->date_from && $tgl <= $request->date_to
                );
            } elseif ($request->filled('date_from')) {
                $tanggalSemua = $tanggalSemua->filter(fn($tgl) => $tgl >= $request->date_from);
            } elseif ($request->filled('date_to')) {
                $tanggalSemua = $tanggalSemua->filter(fn($tgl) => $tgl <= $request->date_to);
            }

            $sort = $request->input('sort', 'desc');
            $tanggalSemua = $sort === 'asc'
                ? $tanggalSemua->sort()->values()
                : $tanggalSemua->sortDesc()->values();

            echo view('header');
            echo view('menu');
            echo view('daily', [
                'tanggalSemua' => $tanggalSemua,
                'sort' => $sort,
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
            ]);
            echo view('footer');
        } else {
            return redirect('/login');
        }
    }


    public function dailyreport(Request $request){
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $carbonTanggal = \Carbon\Carbon::parse($tanggal);
        $hariDalamBulan = $carbonTanggal->daysInMonth;
        $hariKe = $carbonTanggal->day;
        $isAkhirBulan = $hariKe == $hariDalamBulan;

        $detailMenu = DB::table('detail')
            ->join('menu', 'detail.menuid', '=', 'menu.menuid')
            ->join('order', 'detail.orderid', '=', 'order.orderid')
            ->select(
                'menu.menuname',
                DB::raw('SUM(detail.orderpcs) as totalpcs'),
                DB::raw('SUM(detail.totalprice) as totaltotal')
            )
            ->whereDate('order.orderdate', $tanggal)
            ->whereIn('order.status', ['Paid', 'delivered'])
            ->groupBy('menu.menuname')
            ->get();

        $pemasukan = $detailMenu->sum('totaltotal');

        $expenseBulanan = DB::table('expense')->get();

        $detailPengeluaran = $expenseBulanan->map(function ($item) use ($hariDalamBulan, $isAkhirBulan, $tanggal) {
            $total = $isAkhirBulan
                ? $item->total  
                : round($item->total / $hariDalamBulan); 
            return (object)[
                'expensename' => $item->expensename,
                'date' => $tanggal,
                'total' => $total
            ];
        });

        $pengeluaran = $detailPengeluaran->sum('total');
        $laba = $pemasukan - $pengeluaran;

        return view('dailyreport', compact('tanggal', 'pemasukan', 'pengeluaran', 'laba', 'detailMenu', 'detailPengeluaran'));
    }



    public function pdfdaily(Request $request){
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $carbon = \Carbon\Carbon::parse($tanggal);
        $hariDalamBulan = $carbon->daysInMonth;

        $detailMenu = DB::table('detail')
            ->join('menu', 'detail.menuid', '=', 'menu.menuid')
            ->join('order', 'detail.orderid', '=', 'order.orderid')
            ->select(
                'menu.menuname',
                DB::raw('SUM(detail.orderpcs) as totalpcs'),
                DB::raw('SUM(detail.totalprice) as totaltotal')
            )
            ->whereDate('order.orderdate', $tanggal)
            ->whereIn('order.status', ['Paid', 'delivered'])
            ->groupBy('menu.menuname')
            ->get();

        $pemasukan = $detailMenu->sum('totaltotal');

        $expenseBulanan = DB::table('expense')->get();
        $detailPengeluaran = $expenseBulanan->map(function ($item) use ($hariDalamBulan, $tanggal) {
            return (object)[
                'expensename' => $item->expensename,
                'date' => $tanggal,
                'total' => round($item->total / $hariDalamBulan)
            ];
        });

        $pengeluaran = $detailPengeluaran->sum('total');
        $laba = $pemasukan - $pengeluaran;

        $html = view('dailyreport', compact(
            'tanggal',
            'pemasukan',
            'pengeluaran',
            'laba',
            'detailMenu',
            'detailPengeluaran'
        ))->render();

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('HappyDining');
        $pdf->SetAuthor('HappyDining');
        $pdf->SetTitle('Daily Report - ' . $tanggal);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Daily_Report_' . $tanggal . '.pdf', 'I');
    }

    public function exceldaily(Request $request){
        $tanggal = $request->input('tanggal', date('Y-m-d'));
        $carbon = \Carbon\Carbon::parse($tanggal);
        $hariDalamBulan = $carbon->daysInMonth;

        $detailMenu = DB::table('detail')
            ->join('menu', 'detail.menuid', '=', 'menu.menuid')
            ->join('order', 'detail.orderid', '=', 'order.orderid')
            ->select(
                'menu.menuname',
                DB::raw('SUM(detail.orderpcs) as totalpcs'),
                DB::raw('SUM(detail.totalprice) as totaltotal')
            )
            ->whereDate('order.orderdate', $tanggal)
            ->whereIn('order.status', ['Paid', 'delivered'])
            ->groupBy('menu.menuname')
            ->get();

        $pemasukan = $detailMenu->sum('totaltotal');

        $expenseBulanan = DB::table('expense')->get();
        $detailPengeluaran = $expenseBulanan->map(function ($item) use ($hariDalamBulan, $tanggal) {
            return (object)[
                'expensename' => $item->expensename,
                'date' => $tanggal,
                'total' => round($item->total / $hariDalamBulan)
            ];
        });

        $pengeluaran = $detailPengeluaran->sum('total');
        $laba = $pemasukan - $pengeluaran;

        $data = [
            ['Daily Report - ' . $carbon->format('d M Y')],
            [],
            ['Total Income:', 'Rp ' . number_format($pemasukan, 0, ',', '.')],
            ['Total Expenses:', 'Rp ' . number_format($pengeluaran, 0, ',', '.')],
            ['Net Profit:', 'Rp ' . number_format($laba, 0, ',', '.')],
            [],
            ['Menu Sold'],
            ['Menu', 'Quantity Sold', 'Total (Rp)'],
        ];

        foreach ($detailMenu as $item) {
            $data[] = [
                $item->menuname,
                $item->totalpcs,
                'Rp ' . number_format($item->totaltotal, 0, ',', '.')
            ];
        }

        $data[] = [];
        $data[] = ['Expense (Divided per Day)'];
        $data[] = ['Date', 'Expense Name', 'Daily Cost (Rp)'];

        foreach ($detailPengeluaran as $e) {
            $data[] = [
                $e->date,
                $e->expensename,
                'Rp ' . number_format($e->total, 0, ',', '.')
            ];
        }

        $data[] = [];
        $data[] = ['', '', 'Printed on: ' . date('d-m-Y H:i')];

        return Excel::download(new class($data) implements FromArray, WithStyles {
            private $data;
            public function __construct($data) { $this->data = $data; }

            public function array(): array { return $this->data; }

            public function styles(Worksheet $sheet)
            {
                $sheet->mergeCells('A1:C1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                foreach (['A7', 'A15'] as $cell) {
                    $sheet->getStyle($cell)->getFont()->setBold(true)->setSize(12);
                }

                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A8:C'.$highestRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                foreach (range('A','C') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                return [];
            }
        }, 'Daily_Report_' . $tanggal . '.xlsx');
    }


    public function courierOrders(){
        $courierId = session('courierid');

        if (!$courierId) {
            return redirect('login')->with('error', 'Silakan login sebagai kurir terlebih dahulu.');
        }

        $orders = DB::table('order')
            ->where('courierid', $courierId)
            ->whereIn('status', ['pickup_assigned', 'on_delivery', 'delivered'])
            ->paginate(10);

        echo view('header');
        echo view('menu');
        echo view('courierorder', [
            'orders' => $orders
        ]);
        echo('footer');
    }

    public function updateStatus(Request $request, $orderid){
        $request->validate([
            'status' => 'required|in:pickup_assigned,on_delivery,delivered'
        ]);

        $order = DB::table('order')->where('orderid', $orderid)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        DB::table('order')
            ->where('orderid', $orderid)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Successfully updated order status!');
    }

}