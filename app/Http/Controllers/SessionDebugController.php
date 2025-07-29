<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SessionDebugController extends Controller
{
    public function index()
    {
        $sessionId = session()->getId();
        $sessionPath = storage_path('framework/sessions');
        $files = File::files($sessionPath);
        $sessions = [];

        foreach ($files as $file) {
            $fileName = $file->getFilename();
            $content = File::get($file->getPathname());
            $sessions[$fileName] = [
                'is_current' => $fileName === $sessionId,
                'content' => $content,
                'decoded' => $this->decodeSessionContent($content)
            ];
        }

        return view('debug.sessions', [
            'sessions' => $sessions,
            'currentSessionId' => $sessionId
        ]);
    }

    private function decodeSessionContent($content)
    {
        try {
            return unserialize($content);
        } catch (\Exception $e) {
            return "Impossible de désérialiser: " . $e->getMessage();
        }
    }
}
