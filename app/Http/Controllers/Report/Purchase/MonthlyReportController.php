<?php

namespace App\Http\Controllers\Report\Purchase;

use Aaran\Common\Models\Common;
use Aaran\Entries\Models\Purchase;
use Aaran\Master\Models\Company;
use Aaran\Master\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function Spatie\LaravelPdf\Support\pdf;

class MonthlyReportController extends Controller
{
    public function __invoke($month,$year)
    {
        $monthReport=$this->getList($month,$year);
        return pdf('pdf-view.report.purchase.monthly-report', [
            'list'=>$monthReport,
            'cmp' => Company::printDetails(session()->get('company_id')),
        ]) ->landscape();
    }
    public static function getPercent($id,$salesType)
    {
        $obj=DB::table('purchaseitems')
            ->select('purchaseitems.product_id')
            ->where('purchaseitems.purchase_id', $id)
            ->distinct()->get();
        foreach ($obj as $item) {
            $product=Product::find($item->product_id);
            $data[]= $salesType=='CGST-SGST'?
                (Common::find($product->gstpercent_id)->vname/2).'%':
                Common::find($product->gstpercent_id)->vname.'%';
        }
        $dataString = implode(', ', $data);
        return $dataString;
    }

    public function getList($month,$year)
    {
        return Purchase::whereMonth('purchase_date','=',$month)->whereYear('purchase_date','=',$year?:Carbon::now()->format('Y'))
            ->where('company_id','=',session()->get('company_id'))->get();
    }
}