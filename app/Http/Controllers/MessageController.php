<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function chat(User $user)
    {
        return view('chat', compact('user'));
    }
    public function store(MessageRequest $request, User $user)
    {
        if ($request->recipient_id != $user->id) {
            return redirect()->back()->withInput()->withErrors('askjdhkjshd');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mimeType = $file->getClientMimeType();
            $extension = $file->getClientOriginalExtension();

            $category = 'other'; // Default category

            if (str_starts_with($mimeType, 'image')) {
                $category = 'image';
            } elseif (str_starts_with($mimeType, 'video')) {
                $category = 'video';
            } elseif (in_array($extension, ['pdf', 'doc', 'docx', 'txt'])) {
                $category = 'document';
            }


            // Generate a unique file name while preserving the original extension
            $newFileName = uniqid($category . '_') . '.' . $file->getClientOriginalExtension();

            // Store the uploaded file with the custom file name and get the path
            $filePath = $file->storeAs('uploads/' . $category, $newFileName, 'public');
            $request->merge(['attachment'=>$filePath,'attachment_type'=>$category]);
        }
        $msg  = auth()->user()->messages()->create($request->all());
        return redirect()->back()->with(['success' => 'Message send!']);
    }
}
