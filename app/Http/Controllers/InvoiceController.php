<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{

    public function index() {

        $invoices = Invoice::latest()->with('customer')->get();

        return response()->json([
            'invoices' => $invoices
        ], Response::HTTP_OK);

    }

    public function search(Request $request) {

        $search = $request->s;

        if ($search != null) {
            $invoices = Invoice::with('customer')
            ->where('id', 'LIKE', "%$search%")
            ->get();

            return response()->json([
                'invoices' => $invoices
            ], Response::HTTP_OK);
        } else {
           return $this->index();
        }
    }

    public function create(Request $request) {

        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::latest()->first();

        if ($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'term_and_conditions' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()->json($formData);
    }

    public function store(Request $request) {

        $invoiceItem = $request->invoice_item;

        $invoiceData['sub_total'] = $request->subtotal;
        $invoiceData['total'] = $request->total;
        $invoiceData['customer_id'] = $request->customer_id;
        $invoiceData['number'] = $request->number;
        $invoiceData['date'] = $request->date;
        $invoiceData['due_date'] = $request->due_date;
        $invoiceData['discount'] = $request->discount;
        $invoiceData['reference'] = $request->reference;
        $invoiceData['terms_and_conditions'] = $request->terms_and_conditions;

        $invoice = Invoice::create($invoiceData);

        foreach (json_decode($invoiceItem) as $item) {

            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }
    }


    public function update(Request $request, $id) {

        $invoice = Invoice::find($id);

        $invoice->sub_total = $request->subtotal;
        $invoice->total = $request->total;
        $invoice->customer_id = $request->customer_id;
        $invoice->number = $request->number;
        $invoice->date = $request->date;
        $invoice->due_date = $request->due_date;
        $invoice->discount = $request->discount;
        $invoice->reference = $request->reference;
        $invoice->terms_and_conditions = $request->terms_and_conditions;

        $invoice->update($request->all());

        $invoiceItem = $request->invoice_item;

        $invoice->invoice_items()->delete();

        foreach (json_decode($invoiceItem) as $item) {

            $itemData['product_id'] = $item->product_id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemData);
        }


    }

    public function show($id) {

        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice
        ], Response::HTTP_OK);

    }

    public function edit($id) {

        $invoice = Invoice::with(['customer', 'invoice_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice
        ], Response::HTTP_OK);

    }

    public function destroyInvoiceItems($id) {

        $invoiceItem = InvoiceItem::find($id);
        $invoiceItem->delete();

        return response()->json([
            'message' => 'Destroy Invoice Items'
        ], Response::HTTP_NO_CONTENT);

    }

    public function destroyInvoice($id) {

        $invoice = Invoice::find($id);
        $invoice->invoice_items()->delete();
        $invoice->delete();

        return response()->json([
            'message' => 'Destroy Invoice'
        ], Response::HTTP_NO_CONTENT);

    }

}
