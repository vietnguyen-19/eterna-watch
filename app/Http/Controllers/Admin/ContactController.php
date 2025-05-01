<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Contact::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $contacts = $query->orderByDesc('sent_at')->paginate(10);

        $statusCounts = [
            'all' => Contact::count(),
            'new' => Contact::where('status', 'new')->count(),
            'read' => Contact::where('status', 'read')->count(),
            'done' => Contact::where('status', 'done')->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'status', 'statusCounts'));
    }
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        // Trả về view show với dữ liệu contact
        return view('admin.contacts.show', compact('contact'));
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,read,done',
        ]);

        $contact = Contact::findOrFail($id);

        try {
            $contact->status = $request->status;
            $contact->save();

            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái!');
        }
    }
}
