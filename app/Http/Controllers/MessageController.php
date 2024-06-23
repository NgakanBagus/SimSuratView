<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function showAll() : View {
        return view('home', [
            'title' => 'Home',
            'sender_name' => Message::all()
        ]);
    }

    public function show(Message $message) : View {
        return view('message', [
            'title' => 'Message',
            'sender_name' => $message
        ]);
    }

    public function create() : View {
        return view('create', [
            'title' => 'Create Message'
        ]);
    }

    public function store(Request $request) : RedirectResponse {
        $request->validate([
            'title' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:2048', // Validate the PDF file
        ]);

        $pdfPath = $request->file('pdf')->store('pdfs', 'public'); // Store the PDF file

        $new_message = new Message;
        $new_message->title = $request->title;
        $new_message->sender_name = $request->sender_name;
        $new_message->pdf_path = $pdfPath;

        $new_message->save();

        return redirect('/');
    }

    public function edit(Message $message) : View {
        return view('edit', [
            'title' => 'Edit Message',
            'sender_name' => $message
        ]);
    }

    public function update(Request $request, $id) : RedirectResponse {
        $request->validate([
            'title' => 'required|string|max:255',
            'sender_name' => 'required|string|max:255',
            'pdf' => 'nullable|mimes:pdf|max:2048', // Validate the PDF file if provided
        ]);

        $target = Message::find($id);
        $target->title = $request->title;
        $target->sender_name = $request->sender_name;

        if ($request->hasFile('pdf')) {
            // Delete the old PDF file
            if ($target->pdf_path) {
                Storage::disk('public')->delete($target->pdf_path);
            }
            // Store the new PDF file
            $pdfPath = $request->file('pdf')->store('pdfs', 'public');
            $target->pdf_path = $pdfPath;
        }

        $target->save();

        return redirect('/');
    }

    public function delete(Request $request) : RedirectResponse {
        $target = Message::find($request->id);
        if ($target->pdf_path) {
            Storage::disk('public')->delete($target->pdf_path);
        }
        $target->delete();

        return redirect('/');
    }
}
