<?php

namespace App\Livewire\Entries\Sales;

use Aaran\Common\Models\Common;
use Aaran\Entries\Models\Sale;
use Aaran\Master\Models\Company;
use Aaran\Master\Models\Contact;
use Aaran\Master\Models\ContactDetail;
use Aaran\Master\Models\Product;
use Aaran\MasterGst\Models\MasterGstEway;
use Aaran\MasterGst\Models\MasterGstIrn;
use Aaran\MasterGst\Models\MasterGstToken;
use App\Livewire\Forms\MasterGstApi;
use App\Livewire\Trait\CommonTraitNew;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Einvoice extends Component
{
    use CommonTraitNew;

    #region[E-invoice properties]
    public MasterGstApi $masterGstApi;
    public $token;
    public $irnData;
    public $successMessage;
    #endregion

    #region[Properties]
    public $itemList = [];
    public $salesData;
    public $contactDetails;
    public $companyDetails;
    public $addressDetails;
    #endregion

    #region[mount]
    public function mount($id): void
    {
        $this->apiAuthenticate();
        if ($id != 0) {
            $obj = Sale::find($id);
            $this->salesData=$obj;
            $this->companyDetails=Company::find($obj->company_id);
            $this->contactDetails=Contact::find($obj->contact_id);
            $this->addressDetails=ContactDetail::find($obj->billing_id);
            $data = DB::table('saleitems')->select('saleitems.*',
                'products.vname as product_name',
                'colours.vname as colour_name',
                'sizes.vname as size_name',)->join('products', 'products.id', '=', 'saleitems.product_id')
                ->join('commons as colours', 'colours.id', '=', 'saleitems.colour_id')
                ->join('commons as sizes', 'sizes.id', '=', 'saleitems.size_id')->where('sale_id', '=',
                    $id)->get()->transform(function ($data) {
                    return [
                        'saleitem_id' => $data->id,
                        'po_no' => $data->po_no,
                        'dc_no' => $data->dc_no,
                        'no_of_roll' => $data->no_of_roll,
                        'product_name' => $data->product_name,
                        'product_id' => $data->product_id,
                        'colour_name' => $data->colour_name,
                        'colour_id' => $data->colour_id,
                        'size_name' => $data->size_name,
                        'size_id' => $data->size_id,
                        'qty' => $data->qty,
                        'price' => $data->price,
                        'description' => $data->description,
                        'gst_percent' => $data->gst_percent,
                        'taxable' => $data->qty * $data->price,
                        'gst_amount' => ($data->qty * $data->price) * ($data->gst_percent) / 100,
                        'subtotal' => $data->qty * $data->price + (($data->qty * $data->price) * $data->gst_percent / 100),
                    ];
                });
            $this->itemList = $data;
        }

    }

    #endregion

    #region[jsonFormate]
     public function jsonFormate()
     {

         $company = Company::find(session()->get('company_id'));
         $contact = Contact::find($this->salesData->contact_id);
         $contactDetail = ContactDetail::where('contact_id', $contact->id)->first();
         $documentDate = date('d/m/Y', strtotime($this->salesData->invoice_date));
         $jsonData = [
             "Version" => "1.1",
             "TranDtls" => [
                 "TaxSch" => "GST",
                 "SupTyp" => "B2B",
             ],
             "DocDtls" => [
                 "Typ" => "INV",
                 "No" => (string)($this->salesData->invoice_no),
                 "Dt" => (string)($documentDate),
             ],
             "SellerDtls" => [
                 "Gstin" => $company->gstin,
                 "LglNm" => $company->vname,
                 "Addr1" => $company->address_1.','.$company->address_2,
                 "Loc" => Common::find($company->city_id)->vname,
                 "Pin" => Common::find($company->pincode_id)->vname,
                 "Stcd" => Common::find($company->state_id)->desc,

             ],
             "BuyerDtls" => [
                 "Gstin" => $contact->gstin,
                 "LglNm" => $contact->vname,
                 "Pos" => Common::find($contactDetail->state_id)->desc,
                 "Addr1" => $contactDetail->address_1.','.$contactDetail->address_2,
                 "Loc" => Common::find($contactDetail->city_id)->vname,
                 "Pin" => Common::find($contactDetail->pincode_id)->vname,
                 "Stcd" => Common::find($contactDetail->state_id)->desc,
             ],
             "DispDtls" => [
                 "Nm" => $company->vname,
                 "Addr1" => $company->address_1.','.$company->address_2,
                 "Loc" => Common::find($company->city_id)->vname,
                 "Pin" => Common::find($company->pincode_id)->vname,
                 "Stcd" => Common::find($company->state_id)->desc,
             ],
             "ShipDtls" => [
                 "LglNm" => $contact->vname,
                 "Addr1" => $contactDetail->address_1.','.$contactDetail->address_2,
                 "Loc" => Common::find($contactDetail->city_id)->vname,
                 "Pin" => Common::find($contactDetail->pincode_id)->vname,
                 "Stcd" => Common::find($contactDetail->state_id)->desc,
             ],

             "ItemList" => [],

             "ValDtls" => [
                 "AssVal" => $this->salesData->total_taxable,
                 "OthChrg" => $this->salesData->additional,
                 "RndOffAmt" => $this->salesData->round_off,
                 "TotInvVal" => $this->salesData->grand_total,
             ],


             "EwbDtls" => [
                 "Transid" =>$this->salesData->Transid,
                 "Transname" => $this->salesData->Transname,
                 "Distance" => $this->salesData->distance,
                 "Transdocno" => $this->salesData->Transdocno,
                 "TransdocDt" =>  date('d/m/Y', strtotime($this->salesData->TransdocDt)),
                 "Vehno" => $this->salesData->Vehno,
                 "Vehtype" => $this->salesData->Vehtype,
                 "TransMode" => (string)($this->salesData->TransMode),
             ]
         ];
         foreach ($this->itemList as $index => $row) {
             $productData = Product::find($row['product_id']);
             $itemData = [
                 "SlNo" => (string)($index + 1),
                 "PrdDesc"=>$productData->vname,
                 "HsnCd" => Sale::commons($productData->hsncode_id),
                 "BchDtls" => [
                     "Nm" => $productData->vname,
                 ],
                 "Qty" => $row['qty'],
                 "Unit" => Sale::commons($productData->unit_id),
                 "UnitPrice" => $row['price'],
                 "TotAmt" => $row['taxable'],
                 "AssAmt" => $row['taxable'],
                 "GstRt" => $row['gst_percent'],
                 "TotItemVal" => $row['subtotal'],
             ];
             if (Sale::commons($productData->producttype_id) == 'Goods') {
                 $itemData["IsServc"] = 'N';
             } else {
                 $itemData["IsServc"] = 'Y';
             }
             if ($this->salesData->sales_type == 'CGST-SGST') {
                 $itemData["SgstAmt"] = $row['gst_amount'] / 2;
                 $itemData["CgstAmt"] = $row['gst_amount'] / 2;
                 $itemData["IgstAmt"] = 0;
             } else {
                 $itemData["IgstAmt"] = $row['gst_amount'];
                 $itemData["SgstAmt"] =0;
                 $itemData["CgstAmt"] = 0;
             }

             $jsonData["ItemList"][] = $itemData;
         }

         if ($this->salesData->sales_type == 'CGST-SGST') {
             $jsonData["ValDtls"]["CgstVal"] = $this->salesData->total_gst / 2;
             $jsonData["ValDtls"]["SgstVal"] = $this->salesData->total_gst / 2;
             $jsonData["ValDtls"]["IgstVal"] = 0;
         } else {
             $jsonData["ValDtls"]["IgstVal"] = $this->salesData->total_gst;
             $jsonData["ValDtls"]["CgstVal"] = 0;
             $jsonData["ValDtls"]["SgstVal"] = 0;
         }
         $this->irnData=$jsonData;
         $this->generateIrn();
     }
     #endregion

    #region[apiAuthenticate]
     public function apiAuthenticate()
     {
         $apiToken = MasterGstToken::orderByDesc('id')->first();
         if ($apiToken) {
             if (\Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s') < $apiToken->expires_at) {
                 $this->token = $apiToken->token;
             } else {
                 $this->masterGstApi->authenticate();
                 $obj = MasterGstToken::orderByDesc('id')->first();
                 $this->token = $obj->token;
             }
         } else {
             $this->masterGstApi->authenticate();
             $obj = MasterGstToken::orderByDesc('id')->first();
             $this->token = $obj->token;
         }
     }
     #endregion

    #region[generateIrn]
     public function generateIrn()
     {
         $result = $this->masterGstApi->getIrn(new Request(), $this->token, $this->irnData,$this->salesData->id);
         if (isset($result['data']['Irn'])) {
             $this->successMessage = 'E-invoice generated successfully: ' . $result['data']['Irn'];
         } else {
             $this->successMessage = 'Failed to generate IRN.';
         }
         $this->dispatch('notify', ...['type' => 'success', 'content' => $this->successMessage]);
        $this->getRoute();
     }
     #endregion

    #region[render]
    public function getRoute():void
    {
        $this->redirect(route('sales'));
    }

    public function render()
    {
        return view('livewire.entries.sales.einvoice');
    }
    #endregion
}