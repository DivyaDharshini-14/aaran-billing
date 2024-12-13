<?php

namespace App\Livewire\Transaction\Books;

use Aaran\Common\Models\Common;
use Aaran\Master\Models\Contact;
use Aaran\Master\Models\Order;
use Aaran\Transaction\Models\AccountBook;
use Aaran\Transaction\Models\Transaction;
use App\Livewire\Trait\CommonTraitNew;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Aaran\Transaction\Models\CashBook as CashBookModel;

class CashBook extends Component
{
    use CommonTraitNew;

//    #region[properties]
//    public $opening_balance;
//    public $opening_date;
//    public $notes;
//    #endregion
//
//    #region[Get-Save]
//    public function getSave(): void
//    {
//        if ($this->common->vname != '') {
//            if ($this->common->vid == '') {
//                $this->common->vname = preg_replace('/[^A-Za-z0-9\-]/', '', $this->common->vname);
//                $cash_book = new CashBookModel();
//                $extraFields = [
//                    'opening_balance' => $this->opening_balance,
//                    'opening_date' => $this->opening_date,
//                    'notes' => $this->notes,
//                    'user_id' => auth()->id(),
//                    'company_id' => session()->get('company_id'),
//                ];
//                $this->common->save($cash_book, $extraFields);
//                $message = "Saved";
//            } else {
//                $cash_book = CashBookModel::find($this->common->vid);
//                $extraFields = [
//                    'opening_balance' => $this->opening_balance,
//                    'opening_date' => $this->opening_date,
//                    'notes' => $this->notes,
//                    'user_id' => auth()->id(),
//                    'company_id' => session()->get('company_id'),
//                ];
//                $this->common->edit($cash_book, $extraFields);
//                $message = "Updated";
//            }
//            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
//        }
//    }
//    #endregion
//
//    #region[Get-Obj]
//    public function getObj($id)
//    {
//        if ($id) {
//            $bank_book = CashBookModel::find($id);
//            $this->common->vid = $bank_book->id;
//            $this->common->vname = $bank_book->vname;
//            $this->common->active_id = $bank_book->active_id;
//            $this->opening_balance = $bank_book->opening_balance;
//            $this->opening_date = $bank_book->opening_date;
//            $this->notes = $bank_book->notes;
//            return $bank_book;
//        }
//        return null;
//    }
//    #endregion
//
//    #region[Clear-Fields]
//    public function clearFields(): void
//    {
//        $this->common->vid = '';
//        $this->common->vname = '';
//        $this->common->active_id = '1';
//        $this->opening_balance='';
//        $this->opening_date='';
//        $this->notes='';
//    }
//    #endregion
//
//    #region[render]
//    public function getList()
//    {
//        return CashBookModel::select(
//            'cash_books.*',
//        )
//            ->where('cash_books.active_id', '=', $this->getListForm->activeRecord)
//            ->where('cash_books.company_id', '=', session()->get('company_id'))
//            ->orderBy('cash_books.id', $this->getListForm->sortAsc ? 'asc' : 'desc')
//            ->paginate($this->getListForm->perPage);
//    }

    #region[Properties]
    public $paid_to;
    public $purpose;
    public $vdate;
    public $amount;
    public $remarks;
    public $chq_no;
    public $chq_date;
    public $deposit_on;
    public $realised_on;
    public $ref_no;
    public $ref_amount;
    public $verified_by;
    public $verified_on;
    public $against_id;
    public $vch_no;

    public $log;
    public $account_book_id;
    public $account_books = [];
    #endregion

    #region[Get-Save]
    public function getSave(): void
    {
        if ($this->common->vname != '') {
            if ($this->common->vid == '') {
                $Transaction = new Transaction();
                $extraFields = [
                    'acyear' => session()->get('acyear'),
                    'company_id' => session()->get('company_id'),
                    'account_book_id' => $this->account_book_id ?: '1',
                    'contact_id' => $this->contact_id ?: '1',
                    'vch_no' => $this->vch_no,
                    'paid_to' => $this->paid_to,
                    'purpose' => $this->purpose,
                    'order_id' => $this->order_id ?: '1',
                    'trans_type_id' => $this->trans_type_id ?: '108',
                    'mode_id' => $this->mode_id ?: '111',
                    'vdate' => $this->vdate,
                    'receipttype_id' => $this->receipt_type_id ?: '85',
                    'remarks' => $this->remarks,
                    'chq_no' => $this->chq_no,
                    'chq_date' => $this->chq_date,
                    'instrument_bank_id' => $this->instrument_bank_id ?: '1',
                    'deposit_on' => $this->deposit_on,
                    'realised_on' => $this->realised_on,
                    'ref_no' => $this->ref_no,
                    'ref_amount' => $this->ref_amount,
                    'verified_by' => $this->verified_by,
                    'verified_on' => $this->verified_on,
                    'against_id' => $this->against_id ?: '0',
                    'user_id' => auth()->id(),

                ];
                $this->common->save($Transaction, $extraFields);

                $this->common->logEntry($this->vch_no, $this->mode_name, 'create', $this->mode_name . ' for ' . $this->contact_name . ' - ' . $this->mode_name . ' has been created.');

                $this->contactUpdate();
                $message = "Saved";
            } else {
                $Transaction = Transaction::find($this->common->vid);
                $extraFields = [
                    'acyear' => session()->get('acyear'),
                    'company_id' => session()->get('company_id'),
                    'account_book_id' => $this->account_book_id ?: '1',
                    'contact_id' => $this->contact_id,
                    'vch_no' => $this->vch_no,
                    'paid_to' => $this->paid_to,
                    'purpose' => $this->purpose,
                    'order_id' => $this->order_id,
                    'trans_type_id' => $this->trans_type_id,
                    'mode_id' => $this->mode_id,
                    'vdate' => $this->vdate,
                    'receipttype_id' => $this->receipt_type_id,
                    'remarks' => $this->remarks,
                    'chq_no' => $this->chq_no,
                    'chq_date' => $this->chq_date,
//                    'instrument_bank_id' => $this->instrument_bank_id,
                    'deposit_on' => $this->deposit_on,
                    'realised_on' => $this->realised_on,
                    'ref_no' => $this->ref_no,
                    'ref_amount' => $this->ref_amount,
                    'verified_by' => $this->verified_by,
                    'verified_on' => $this->verified_on,
                    'against_id' => $this->against_id,
//                    'account_id' => $this->account_id,
                    'user_id' => auth()->id(),
                ];
                $this->common->edit($Transaction, $extraFields);

                $this->common->logEntry($this->vch_no, $this->mode_name, 'update', $this->mode_name . ' for ' . $this->contact_name . ' - ' . $this->mode_name . ' has been updated and the amount is ' . $this->common->vname . ' by ' . $this->trans_type_name);

                $this->contactUpdate();
                $message = "Updated";
            }
            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
        }
    }

    public function contactUpdate()
    {
        if ($this->contact_id) {
            $obj = Contact::find($this->contact_id);
            $outstanding = $obj->outstanding - $this->common->vname;
            $obj->outstanding = $outstanding;
            $obj->save();
        }
    }
    #endregion

    #region[Mount]
    public function mount()
    {
        $this->account_books = AccountBook::with('transType')->where('trans_type_id',108)->get();
    }
    #endregion

    #region[Contact]

    public $contact_id = '';
    public $contact_name = '';
    public \Illuminate\Database\Eloquent\Collection $contactCollection;
    public $highlightContact = 0;
    public $contactTyped = false;

    public function decrementContact(): void
    {
        if ($this->highlightContact === 0) {
            $this->highlightContact = count($this->contactCollection) - 1;
            return;
        }
        $this->highlightContact--;
    }

    public function incrementContact(): void
    {
        if ($this->highlightContact === count($this->contactCollection) - 1) {
            $this->highlightContact = 0;
            return;
        }
        $this->highlightContact++;
    }

    public function setContact($name, $id): void
    {
        $this->contact_name = $name;
        $this->contact_id = $id;
        $this->getContactList();
    }

    public function enterContact(): void
    {
        $obj = $this->contactCollection[$this->highlightContact] ?? null;

        $this->contact_name = '';
        $this->contactCollection = Collection::empty();
        $this->highlightContact = 0;

        $this->contact_name = $obj['vname'] ?? '';
        $this->contact_id = $obj['id'] ?? '';
    }

    #[On('refresh-contact')]
    public function refreshContact($v): void
    {
        $this->contact_id = $v['id'];
        $this->contact_name = $v['name'];
        $this->contactTyped = false;

    }

    public function getContactList(): void
    {

        $this->contactCollection = $this->contact_name ? Contact::search(trim($this->contact_name))
            ->where('company_id', '=', session()->get('company_id'))
            ->get() : Contact::where('company_id', '=', session()->get('company_id'))->get();

    }

    #endregion

    #region[receipt_type]
    public $receipt_type_id = '';
    public $receipt_type_name = '';
    public \Illuminate\Support\Collection $receipt_typeCollection;
    public $highlightReceiptType = 0;
    public $receipt_typeTyped = false;

    public function decrementReceiptType(): void
    {
        if ($this->highlightReceiptType === 0) {
            $this->highlightReceiptType = count($this->receipt_typeCollection) - 1;
            return;
        }
        $this->highlightReceiptType--;
    }

    public function incrementReceiptType(): void
    {
        if ($this->highlightReceiptType === count($this->receipt_typeCollection) - 1) {
            $this->highlightReceiptType = 0;
            return;
        }
        $this->highlightReceiptType++;
    }

    public function setReceiptType($name, $id): void
    {
        $this->receipt_type_name = $name;
        $this->receipt_type_id = $id;
        $this->getReceiptTypeList();
    }

    public function enterReceiptType(): void
    {
        $obj = $this->receipt_typeCollection[$this->highlightReceiptType] ?? null;

        $this->receipt_type_name = '';
        $this->receipt_typeCollection = Collection::empty();
        $this->highlightReceiptType = 0;

        $this->receipt_type_name = $obj['vname'] ?? '';
        $this->receipt_type_id = $obj['id'] ?? '';
    }

    public function refreshReceiptType($v): void
    {
        $this->receipt_type_id = $v['id'];
        $this->receipt_type_name = $v['name'];
        $this->receipt_typeTyped = false;
    }

    public function receiptTypeSave($name)
    {
        $obj = Common::create([
            'label_id' => 14,
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshReceiptType($v);
    }

    public function getReceiptTypeList(): void
    {
        $this->receipt_typeCollection = $this->receipt_type_name ?
            Common::search(trim($this->receipt_type_name))->where('label_id', '=', '14')->get() :
            Common::where('label_id', '=', '14')->Orwhere('id', '=', '1')->get();
    }
#endregion

    #region[Order]

    #[Rule('required')]
    public $order_id = '';
    public $order_name = '';
    public Collection $orderCollection;
    public $highlightOrder = 0;
    public $orderTyped = false;

    public function decrementOrder(): void
    {
        if ($this->highlightOrder === 0) {
            $this->highlightOrder = count($this->orderCollection) - 1;
            return;
        }
        $this->highlightOrder--;
    }

    public function incrementOrder(): void
    {
        if ($this->highlightOrder === count($this->orderCollection) - 1) {
            $this->highlightOrder = 0;
            return;
        }
        $this->highlightOrder++;
    }

    public function setOrder($name, $id): void
    {
        $this->order_name = $name;
        $this->order_id = $id;
        $this->getOrderList();
    }

    public function enterOrder(): void
    {
        $obj = $this->orderCollection[$this->highlightOrder] ?? null;

        $this->order_name = '';
        $this->orderCollection = Collection::empty();
        $this->highlightOrder = 0;

        $this->order_name = $obj['vname'] ?? '';
        $this->order_id = $obj['id'] ?? '';
    }

    #[On('refresh-order')]
    public function refreshOrder($v): void
    {
        $this->order_id = $v['id'];
        $this->order_name = $v['name'];
        $this->orderTyped = false;

    }

    public function getOrderList(): void
    {
        $this->orderCollection = $this->order_name ? Order::search(trim($this->order_name))
            ->where('company_id', '=', session()->get('company_id'))
            ->get() : Order::where('company_id', '=', session()->get('company_id'))->get();;
    }

    #endregion

    #region[instrumentBank]
    public $instrument_bank_id = '';
    public $instrument_bank_name = '';
    public \Illuminate\Support\Collection $instrumentBankCollection;
    public $highlightInstrumentBank = 0;
    public $instrumentBankTyped = false;

    public function decrementInstrumentBank(): void
    {
        if ($this->highlightInstrumentBank === 0) {
            $this->highlightInstrumentBank = count($this->instrumentBankCollection) - 1;
            return;
        }
        $this->highlightInstrumentBank--;
    }

    public function incrementInstrumentBank(): void
    {
        if ($this->highlightInstrumentBank === count($this->instrumentBankCollection) - 1) {
            $this->highlightInstrumentBank = 0;
            return;
        }
        $this->highlightInstrumentBank++;
    }

    public function setInstrumentBank($name, $id): void
    {
        $this->instrument_bank_name = $name;
        $this->instrument_bank_id = $id;
        $this->getInstrumentBankList();
    }

    public function enterInstrumentBank(): void
    {
        $obj = $this->instrumentBankCollection[$this->highlightInstrumentBank] ?? null;

        $this->instrument_bank_name = '';
        $this->instrumentBankCollection = Collection::empty();
        $this->highlightInstrumentBank = 0;

        $this->instrument_bank_name = $obj['vname'] ?? '';
        $this->instrument_bank_id = $obj['id'] ?? '';
    }

    public function refreshInstrumentBank($v): void
    {
        $this->instrument_bank_id = $v['id'];
        $this->instrument_bank_name = $v['name'];
        $this->instrumentBankTyped = false;
    }

    public function instrumentBankSave($name)
    {
        $obj = Common::create([
            'label_id' => 25,
            'vname' => $name,
            'active_id' => '1'
        ]);

        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshInstrumentBank($v);
    }

    public function getInstrumentBankList(): void
    {
        $this->instrumentBankCollection = $this->instrument_bank_name ?
            Common::search(trim($this->instrument_bank_name))->where('label_id', '=', '25')->get() :
            Common::where('label_id', '=', '25')
                ->Orwhere('id', '=', '1')
                ->get();
    }
#endregion

    #region[mode]
    public $mode_id = '';
    public $mode_name = '';
    public \Illuminate\Support\Collection $modeCollection;
    public $highlightMode = 0;
    public $modeTyped = false;

    public function decrementMode(): void
    {
        if ($this->highlightMode === 0) {
            $this->highlightMode = count($this->modeCollection) - 1;
            return;
        }
        $this->highlightMode--;
    }

    public function incrementMode(): void
    {
        if ($this->highlightMode === count($this->modeCollection) - 1) {
            $this->highlightMode = 0;
            return;
        }
        $this->highlightMode++;
    }

    public function setMode($name, $id): void
    {
        $this->mode_name = $name;
        $this->mode_id = $id;
        $this->getModeList();
    }

    public function enterMode(): void
    {
        $obj = $this->modeCollection[$this->highlightMode] ?? null;

        $this->mode_name = '';
        $this->modeCollection = Collection::empty();
        $this->highlightMode = 0;

        $this->mode_name = $obj['vname'] ?? '';
        $this->mode_id = $obj['id'] ?? '';
    }

    public function refreshMode($v): void
    {
        $this->mode_id = $v['id'];
        $this->mode_name = $v['name'];
        $this->modeTyped = false;
    }

    public function modeSave($name)
    {
        $obj = Common::create([
            'label_id' => 20,
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshMode($v);
    }

    public function getModeList(): void
    {
        $this->modeCollection = $this->mode_name ?
            Common::search(trim($this->mode_name))->where('label_id', '=', '20')->get() :
            Common::where('label_id', '=', '20')->get();
    }

#endregion

    #region[trans_type]
    public $trans_type_id = '';
    public $trans_type_name = '';
    public \Illuminate\Support\Collection $trans_typeCollection;
    public $highlightTransType = 0;
    public $trans_typeTyped = false;

    public function decrementTransType(): void
    {
        if ($this->highlightTransType === 0) {
            $this->highlightTransType = count($this->trans_typeCollection) - 1;
            return;
        }
        $this->highlightTransType--;
    }

    public function incrementTransType(): void
    {
        if ($this->highlightTransType === count($this->trans_typeCollection) - 1) {
            $this->highlightTransType = 0;
            return;
        }
        $this->highlightTransType++;
    }

    public function setTransType($name, $id): void
    {
        $this->trans_type_name = $name;
        $this->trans_type_id = $id;
        $this->getTransTypeList();
    }

    public function enterTransType(): void
    {
        $obj = $this->trans_typeCollection[$this->highlightTransType] ?? null;

        $this->trans_type_name = '';
        $this->trans_typeCollection = \Illuminate\Database\Eloquent\Collection::empty();
        $this->highlightTransType = 0;

        $this->trans_type_name = $obj['vname'] ?? '';
        $this->trans_type_id = $obj['id'] ?? '';
    }

    public function refreshTransType($v): void
    {
        $this->trans_type_id = $v['id'];
        $this->trans_type_name = $v['name'];
        $this->trans_typeTyped = false;
    }

    public function transTypeSave($name)
    {
        $obj = Common::create([
            'label_id' => 19,
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshTransType($v);
    }

    public function getTransTypeList(): void
    {
        $this->trans_typeCollection = $this->trans_type_name ?
            Common::search(trim($this->trans_type_name))->where('label_id', '=', '19')->get() :
            Common::where('label_id', '=', '19')->get();
    }
#endregion

    #region[Get-Obj]
    public function getObj($id)
    {
        if ($id) {
            $Transaction = Transaction::find($id);
            $this->common->vid = $Transaction->id;
            $this->common->vname = $Transaction->vname;
            $this->common->active_id = $Transaction->active_id;
            $this->account_book_id = $Transaction->account_book_id;
            $this->contact_id = $Transaction->contact_id;
            $this->contact_name = $Transaction->contact_id ? Contact::find($Transaction->contact_id)->vname : '';
            $this->vch_no = $Transaction->vch_no;
            $this->paid_to = $Transaction->paid_to;
            $this->purpose = $Transaction->purpose;
            $this->order_id = $Transaction->order_id;
            $this->order_name = $Transaction->order_id ? Order::find($Transaction->order_id)->vname : '';
            $this->trans_type_id = $Transaction->trans_type_id;
            $this->trans_type_name = $Transaction->trans_type_id ? Common::find($Transaction->trans_type_id)->vname : '';
            $this->mode_id = $Transaction->mode_id;
            $this->mode_name = $Transaction->mode_id ? Common::find($Transaction->mode_id)->vname : '';
            $this->vdate = $Transaction->vdate;
            $this->amount = $Transaction->amount;
            $this->receipt_type_id = $Transaction->receipttype_id;
            $this->receipt_type_name = $Transaction->receipttype_id ? Common::find($Transaction->receipttype_id)->vname : '';
            $this->remarks = $Transaction->remarks;
            $this->chq_no = $Transaction->chq_no;
            $this->chq_date = $Transaction->chq_date;
            $this->instrument_bank_id = $Transaction->instrument_bank_id;
            $this->instrument_bank_name = $Transaction->instrument_bank_id ? Common::find($Transaction->instrument_bank_id)->vname : '';
            $this->deposit_on = $Transaction->deposit_on;
            $this->realised_on = $Transaction->realised_on;
            $this->ref_no = $Transaction->ref_no;
            $this->ref_amount = $Transaction->ref_amount;
            $this->verified_by = $Transaction->verified_by;
            $this->verified_on = $Transaction->verified_on;
            $this->against_id = $Transaction->against_id;
            $contact_outstanding = Contact::find($this->contact_id);
            $contact_outstanding->outstanding = $contact_outstanding->outstanding + $this->common->vname;
            $contact_outstanding->save();
            return $Transaction;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]
    public function clearFields(): void
    {
        $this->common->vid = '';
        $this->common->vname = '0';
        $this->common->active_id = '1';
        $this->contact_id = '';
        $this->contact_name = '';
        $this->paid_to = '';
        $this->purpose = '';
        $this->order_id = '';
        $this->order_name = '';
        $this->amount = '';
        $this->trans_type_id = 108;
        $this->trans_type_name = 108;
        $this->remarks = '';
        $this->chq_no = '';
        $this->chq_date = '';
        $this->instrument_bank_id = '';
        $this->instrument_bank_name = '';
        $this->deposit_on = '';
        $this->realised_on = '';
        $this->ref_no = '';
        $this->ref_amount = '';
        $this->verified_by = '';
        $this->verified_on = '';
        $this->receipt_type_id = '';
        $this->receipt_type_name = '';
        $this->account_book_id = '';
        $this->vdate = Carbon::now()->format('Y-m-d');
    }

    #endregion

    public $cashBookData = [];
    public $payments = [];
    public function getCashbookData()
    {
        $this->cashBookData = AccountBook::where('trans_type_id','108')->get();

}

    public function getPayment()
    {
        $this->payments = Transaction::with('accountBook')->where('trans_type_id', 108)->latest()->get();
    }
    public function render()
    {
        $this->getContactList();
        $this->getReceiptTypeList();
        $this->getOrderList();
        $this->getInstrumentBankList();
        $this->getCashbookData();
        $this->getPayment();
        return view('livewire.transaction.books.cash-book')->with([
//            'list' => $this->getList()
            'list' => $this->getListForm->getList(Transaction::class, function ($query) {
                return $query->where('mode_id', $this->mode_id)
                    ->where('acyear', session()->get('acyear'))
                    ->where('company_id', session()->get('company_id'));
            }),
        ]);
    }
    #endregion
}
