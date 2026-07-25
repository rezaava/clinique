<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Device;
use App\Models\DevicePart;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\InventoryTransaction;
use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    // ==================== Consumables ====================
    
    public function consumablesIndex()
    {
        $consumables = Consumable::with(['brand', 'primarySupplier'])
            ->orderBy('name')
            ->paginate(20);
            
        $lowStock = Consumable::with(['brand'])
            ->whereColumn('stock_quantity', '<=', 'minimum_stock')
            ->get();
            
        return view('inventory.consumables.index', compact('consumables', 'lowStock'));
    }
    
    public function consumablesCreate()
    {
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.consumables.create', compact('brands', 'suppliers'));
    }
    
    public function consumablesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'sku' => 'nullable|string|max:100|unique:consumables',
            'brand_id' => 'nullable|exists:brands,id',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $consumable = new Consumable();
            $consumable->name = $request->name;
            $consumable->sku = $request->sku ?? 'SKU-' . strtoupper(Str::random(8));
            $consumable->brand_id = $request->brand_id;
            $consumable->stock_quantity = $request->stock_quantity;
            $consumable->minimum_stock = $request->minimum_stock;
            $consumable->unit_price = $request->unit_price;
            $consumable->unit = $request->unit;
            $consumable->expiry_date = $request->expiry_date;
            $consumable->notes = $request->notes;
            $consumable->supplier_id = $request->supplier_id;
            $consumable->save();

            if ($request->stock_quantity > 0) {
                $this->createInventoryTransaction(
                    $consumable,
                    'purchase',
                    'in',
                    $request->stock_quantity,
                    $request->unit_price,
                    null,
                    'موجودی اولیه'
                );
            }

            return redirect()->route('inventory.consumables.index')
                ->with('success', 'ماده مصرفی با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ایجاد ماده مصرفی: ' . $e->getMessage());
        }
    }
    
    public function consumablesEdit($id)
    {
        $consumable = Consumable::findOrFail($id);
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.consumables.edit', compact('consumable', 'brands', 'suppliers'));
    }
    
    public function consumablesUpdate(Request $request, $id)
    {
        $consumable = Consumable::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'sku' => 'nullable|string|max:100|unique:consumables,sku,' . $id,
            'brand_id' => 'nullable|exists:brands,id',
            'minimum_stock' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $consumable->name = $request->name;
            $consumable->sku = $request->sku;
            $consumable->brand_id = $request->brand_id;
            $consumable->minimum_stock = $request->minimum_stock;
            $consumable->unit_price = $request->unit_price;
            $consumable->unit = $request->unit;
            $consumable->expiry_date = $request->expiry_date;
            $consumable->notes = $request->notes;
            $consumable->supplier_id = $request->supplier_id;
            $consumable->save();

            return redirect()->route('inventory.consumables.index')
                ->with('success', 'ماده مصرفی با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در به‌روزرسانی: ' . $e->getMessage());
        }
    }
    
    public function consumablesDelete($id)
    {
        try {
            $consumable = Consumable::findOrFail($id);
            
            if ($consumable->stock_quantity > 0) {
                return back()->with('error', 'امکان حذف ماده مصرفی با موجودی غیرصفر وجود ندارد.');
            }
            
            $consumable->delete();
            
            return redirect()->route('inventory.consumables.index')
                ->with('success', 'ماده مصرفی با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در حذف: ' . $e->getMessage());
        }
    }
    
    // ==================== Devices ====================
    
    public function devicesIndex()
    {
        $devices = Device::with(['brand', 'primarySupplier', 'deviceParts'])
            ->orderBy('name')
            ->paginate(20);
            
        $needMaintenance = Device::where('last_maintenance_date', '<=', now()->subMonths(6))
            ->orWhere('status', 'maintenance')
            ->get();
            
        return view('inventory.devices.index', compact('devices', 'needMaintenance'));
    }
    
    public function devicesCreate()
    {
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.devices.create', compact('brands', 'suppliers'));
    }
    
    public function devicesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:devices',
            'brand_id' => 'nullable|exists:brands,id',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'total_shots_limit' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $device = new Device();
            $device->name = $request->name;
            $device->model = $request->model;
            $device->serial_number = $request->serial_number;
            $device->brand_id = $request->brand_id;
            $device->purchase_date = $request->purchase_date;
            $device->purchase_price = $request->purchase_price;
            $device->warranty_months = $request->warranty_months;
            $device->total_shots_limit = $request->total_shots_limit;
            $device->used_shots = 0;
            $device->notes = $request->notes;
            $device->status = 'active';
            $device->supplier_id = $request->supplier_id;
            $device->save();

            return redirect()->route('inventory.devices.index')
                ->with('success', 'دستگاه با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ایجاد دستگاه: ' . $e->getMessage());
        }
    }
    
    public function devicesEdit($id)
    {
        $device = Device::findOrFail($id);
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.devices.edit', compact('device', 'brands', 'suppliers'));
    }
    
    public function devicesUpdate(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100|unique:devices,serial_number,' . $id,
            'brand_id' => 'nullable|exists:brands,id',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'total_shots_limit' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,maintenance,broken,retired',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $device->name = $request->name;
            $device->model = $request->model;
            $device->serial_number = $request->serial_number;
            $device->brand_id = $request->brand_id;
            $device->purchase_date = $request->purchase_date;
            $device->purchase_price = $request->purchase_price;
            $device->warranty_months = $request->warranty_months;
            $device->total_shots_limit = $request->total_shots_limit;
            $device->notes = $request->notes;
            $device->status = $request->status;
            $device->supplier_id = $request->supplier_id;
            $device->save();

            return redirect()->route('inventory.devices.index')
                ->with('success', 'دستگاه با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در به‌روزرسانی: ' . $e->getMessage());
        }
    }
    
    public function devicesDelete($id)
    {
        try {
            $device = Device::findOrFail($id);
            
            if ($device->deviceParts()->count() > 0) {
                return back()->with('error', 'امکان حذف دستگاه با قطعات موجود وجود ندارد.');
            }
            
            $device->delete();
            
            return redirect()->route('inventory.devices.index')
                ->with('success', 'دستگاه با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در حذف: ' . $e->getMessage());
        }
    }
    
    // ==================== Parts ====================
    
    public function partsIndex()
    {
        $parts = DevicePart::with(['device', 'brand', 'primarySupplier'])
            ->orderBy('name')
            ->paginate(20);
            
        return view('inventory.parts.index', compact('parts'));
    }
    
    public function partsCreate()
    {
        $devices = Device::where('status', 'active')->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.parts.create', compact('devices', 'brands', 'suppliers'));
    }
    
    public function partsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'part_number' => 'nullable|string|max:100',
            'device_id' => 'nullable|exists:devices,id',
            'brand_id' => 'nullable|exists:brands,id',
            'max_shots' => 'nullable|integer|min:0',
            'installation_date' => 'nullable|date',
            'replacement_date' => 'nullable|date|after:installation_date',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $part = new DevicePart();
            $part->name = $request->name;
            $part->part_number = $request->part_number;
            $part->device_id = $request->device_id;
            $part->brand_id = $request->brand_id;
            $part->max_shots = $request->max_shots;
            $part->used_shots = 0;
            $part->installation_date = $request->installation_date;
            $part->replacement_date = $request->replacement_date;
            $part->notes = $request->notes;
            $part->supplier_id = $request->supplier_id;
            $part->save();

            return redirect()->route('inventory.parts.index')
                ->with('success', 'قطعه با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ایجاد قطعه: ' . $e->getMessage());
        }
    }
    
    public function partsEdit($id)
    {
        $part = DevicePart::findOrFail($id);
        $devices = Device::where('status', 'active')->get();
        $brands = \App\Models\Brand::where('is_active', true)->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.parts.edit', compact('part', 'devices', 'brands', 'suppliers'));
    }
    
    public function partsUpdate(Request $request, $id)
    {
        $part = DevicePart::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'part_number' => 'nullable|string|max:100',
            'device_id' => 'nullable|exists:devices,id',
            'brand_id' => 'nullable|exists:brands,id',
            'max_shots' => 'nullable|integer|min:0',
            'installation_date' => 'nullable|date',
            'replacement_date' => 'nullable|date|after:installation_date',
            'notes' => 'nullable|string',
            'supplier_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $part->name = $request->name;
            $part->part_number = $request->part_number;
            $part->device_id = $request->device_id;
            $part->brand_id = $request->brand_id;
            $part->max_shots = $request->max_shots;
            $part->installation_date = $request->installation_date;
            $part->replacement_date = $request->replacement_date;
            $part->notes = $request->notes;
            $part->supplier_id = $request->supplier_id;
            $part->save();

            return redirect()->route('inventory.parts.index')
                ->with('success', 'قطعه با موفقیت به‌روزرسانی شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در به‌روزرسانی: ' . $e->getMessage());
        }
    }
    
    public function partsDelete($id)
    {
        try {
            $part = DevicePart::findOrFail($id);
            $part->delete();
            
            return redirect()->route('inventory.parts.index')
                ->with('success', 'قطعه با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در حذف: ' . $e->getMessage());
        }
    }
    
    // ==================== Purchase Requests ====================
    
    public function purchaseRequestsIndex()
    {
        $requests = PurchaseRequest::with(['requestedBy', 'approvedBy', 'supplier', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $pendingRequests = PurchaseRequest::where('status', 'pending')->count();
        
        return view('inventory.purchases.index', compact('requests', 'pendingRequests'));
    }
    
    public function purchaseRequestsCreate()
    {
        $consumables = Consumable::whereColumn('stock_quantity', '<=', 'minimum_stock')->get();
        $suppliers = User::whereHas('roles', function($q) {
            $q->where('name', 'supplier');
        })->get();
        
        return view('inventory.purchases.create', compact('consumables', 'suppliers'));
    }
    
    public function purchaseRequestsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:consumable,device_part,device',
            'supplier_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'expected_delivery_date' => 'nullable|date|after:today',
            'items' => 'required|array|min:1',
            'items.*.purchasable_type' => 'required|string',
            'items.*.purchasable_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $purchaseRequest = new PurchaseRequest();
            $purchaseRequest->requested_by = Auth::id();
            $purchaseRequest->supplier_id = $request->supplier_id;
            $purchaseRequest->request_number = 'PR-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $purchaseRequest->type = $request->type;
            $purchaseRequest->status = 'pending';
            $purchaseRequest->description = $request->description;
            $purchaseRequest->expected_delivery_date = $request->expected_delivery_date;
            $purchaseRequest->total_price = 0;
            $purchaseRequest->save();

            $totalPrice = 0;

            foreach ($request->items as $item) {
                $purchaseItem = new PurchaseRequestItem();
                $purchaseItem->purchase_request_id = $purchaseRequest->id;
                $purchaseItem->purchasable_type = $item['purchasable_type'];
                $purchaseItem->purchasable_id = $item['purchasable_id'];
                $purchaseItem->quantity = $item['quantity'];
                $purchaseItem->unit_price = $item['unit_price'];
                $purchaseItem->total_price = $item['quantity'] * $item['unit_price'];
                $purchaseItem->notes = $item['notes'] ?? null;
                $purchaseItem->save();
                
                $totalPrice += $purchaseItem->total_price;
            }

            $purchaseRequest->total_price = $totalPrice;
            $purchaseRequest->save();

            // TO DO: Notification to admin

            return redirect()->route('inventory.purchases.index')
                ->with('success', 'درخواست خرید با موفقیت ثبت شد. منتظر تایید مدیر باشید.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت درخواست: ' . $e->getMessage());
        }
    }
    
    public function purchaseRequestsApprove(Request $request, $id)
    {
        try {
            $purchaseRequest = PurchaseRequest::findOrFail($id);
            
            if ($purchaseRequest->status !== 'pending') {
                return back()->with('error', 'این درخواست قبلاً تعیین وضعیت شده است.');
            }
            
            $purchaseRequest->status = 'approved';
            $purchaseRequest->approved_by = Auth::id();
            $purchaseRequest->approved_at = now();
            $purchaseRequest->save();

            // TO DO: Notification to requester

            return redirect()->route('inventory.purchases.index')
                ->with('success', 'درخواست خرید با موفقیت تایید شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در تایید درخواست: ' . $e->getMessage());
        }
    }
    
    public function purchaseRequestsReject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $purchaseRequest = PurchaseRequest::findOrFail($id);
            
            if ($purchaseRequest->status !== 'pending') {
                return back()->with('error', 'این درخواست قبلاً تعیین وضعیت شده است.');
            }
            
            $purchaseRequest->status = 'rejected';
            $purchaseRequest->rejection_reason = $request->rejection_reason;
            $purchaseRequest->save();

            // TO DO: Notification to requester

            return redirect()->route('inventory.purchases.index')
                ->with('success', 'درخواست خرید رد شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در رد درخواست: ' . $e->getMessage());
        }
    }
    
    public function purchaseRequestsReceive(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'received_date' => 'required|date',
            'items.*.received_quantity' => 'required|integer|min:0',
            'items.*.received_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $purchaseRequest = PurchaseRequest::findOrFail($id);
            
            if ($purchaseRequest->status !== 'approved' && $purchaseRequest->status !== 'ordered') {
                return back()->with('error', 'این درخواست قابل دریافت نیست.');
            }
            
            $purchaseRequest->status = 'received';
            $purchaseRequest->received_date = $request->received_date;
            $purchaseRequest->received_at = now();
            $purchaseRequest->save();

            foreach ($purchaseRequest->items as $item) {
                $receivedQty = $request->items[$item->id]['received_quantity'] ?? $item->quantity;
                
                if ($receivedQty > 0) {
                    $consumable = Consumable::find($item->purchasable_id);
                    if ($consumable) {
                        $oldStock = $consumable->stock_quantity;
                        $consumable->stock_quantity += $receivedQty;
                        $consumable->save();
                        
                        $this->createInventoryTransaction(
                            $consumable,
                            'purchase',
                            'in',
                            $receivedQty,
                            $item->unit_price,
                            $purchaseRequest->id,
                            'دریافت کالا از درخواست خرید ' . $purchaseRequest->request_number
                        );
                    }
                }
                
                $item->received_quantity = $receivedQty;
                $item->received_notes = $request->items[$item->id]['received_notes'] ?? null;
                $item->save();
            }

            // TO DO: Notification to requester

            return redirect()->route('inventory.purchases.index')
                ->with('success', 'کالا با موفقیت دریافت و به انبار اضافه شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در دریافت کالا: ' . $e->getMessage());
        }
    }
    
    // ==================== Transactions ====================
    
    public function transactionsIndex(Request $request)
    {
        $query = InventoryTransaction::with(['user', 'inventoriable']);
        
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->direction) {
            $query->where('direction', $request->direction);
        }
        if ($request->date_from) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate(30);
            
        return view('inventory.transactions.index', compact('transactions'));
    }
    
    // ==================== Maintenance ====================
    
    public function maintenanceIndex()
    {
        $logs = MaintenanceLog::with(['device', 'performedBy'])
            ->orderBy('maintenance_date', 'desc')
            ->paginate(20);
            
        $devices = Device::where('status', 'active')->get();
        
        return view('inventory.maintenance.index', compact('logs', 'devices'));
    }
    
    public function maintenanceStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|exists:devices,id',
            'type' => 'required|in:regular,emergency,repair,replacement',
            'maintenance_date' => 'required|date',
            'description' => 'nullable|string',
            'parts_replaced' => 'nullable|string',
            'notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'next_maintenance_date' => 'nullable|date|after:maintenance_date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $log = new MaintenanceLog();
            $log->device_id = $request->device_id;
            $log->performed_by = Auth::id();
            $log->type = $request->type;
            $log->maintenance_date = $request->maintenance_date;
            $log->description = $request->description;
            $log->parts_replaced = $request->parts_replaced;
            $log->notes = $request->notes;
            $log->cost = $request->cost ?? 0;
            $log->next_maintenance_date = $request->next_maintenance_date;
            $log->save();

            $device = Device::find($request->device_id);
            $device->last_maintenance_date = $request->maintenance_date;
            $device->save();

            return redirect()->route('inventory.maintenance.index')
                ->with('success', 'سرویس دستگاه با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return back()->with('error', 'خطا در ثبت سرویس: ' . $e->getMessage());
        }
    }
    
    public function maintenanceShow($id)
    {
        $log = MaintenanceLog::with(['device', 'performedBy'])->findOrFail($id);
        return view('inventory.maintenance.show', compact('log'));
    }
    
    // ==================== Helper Methods ====================
    
    private function createInventoryTransaction($inventoriable, $type, $direction, $quantity, $unitPrice = null, $purchaseRequestId = null, $description = null)
    {
        $transaction = new InventoryTransaction();
        $transaction->inventoriable_type = get_class($inventoriable);
        $transaction->inventoriable_id = $inventoriable->id;
        $transaction->type = $type;
        $transaction->direction = $direction;
        $transaction->quantity = $quantity;
        $transaction->previous_quantity = $inventoriable->stock_quantity - $quantity;
        $transaction->current_quantity = $inventoriable->stock_quantity;
        $transaction->unit_price = $unitPrice;
        $transaction->total_price = $unitPrice ? $quantity * $unitPrice : null;
        $transaction->user_id = Auth::id();
        $transaction->purchase_request_id = $purchaseRequestId;
        $transaction->description = $description;
        $transaction->transaction_date = now();
        $transaction->save();
        
        return $transaction;
    }
}