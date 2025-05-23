<?php

namespace App\Http\Controllers;

use Core\App;
use Core\Database;
use Core\Validator;

class NoteController extends Controller
{
    private $db;
    
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
    
    public function index()
    {
        $notes = $this->db->query('SELECT * FROM notes WHERE user_id = :user_id ORDER BY created_at DESC', [
            'user_id' => $this->currentUserId()
        ])->get();
        
        return $this->view('notes/index.view', [
            'heading' => 'My Notes',
            'notes' => $notes
        ]);
    }
    
    public function show()
    {
        $note = $this->findNote($_GET['id']);
        
        return $this->view('notes/show.view', [
            'heading' => 'Note',
            'note' => $note
        ]);
    }
    
    public function create()
    {
        return $this->view('notes/create.view', [
            'heading' => 'Create Note',
            'errors' => []
        ]);
    }
    
    public function store()
    {
        $errors = [];
        if (!Validator::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1,000 characters is required.';
        }
        
        if (!empty($errors)) {
            return $this->view('notes/create.view', [
                'heading' => 'Create Note',
                'errors' => $errors
            ]);
        }
        
        $this->db->query('INSERT INTO notes (body, user_id, created_at) VALUES (:body, :user_id, NOW())', [
            'body' => $_POST['body'],
            'user_id' => $this->currentUserId()
        ]);
        
        return $this->redirect('/notes');
    }
    
    public function edit()
    {
        $note = $this->findNote($_GET['id']);
        
        return $this->view('notes/edit.view', [
            'heading' => 'Edit Note',
            'errors' => [],
            'note' => $note
        ]);
    }
    
    public function update()
    {
        $note = $this->findNote($_POST['id']);
        
        $errors = [];
        if (!Validator::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'A body of no more than 1,000 characters is required.';
        }
        
        if (!empty($errors)) {
            return $this->view('notes/edit.view', [
                'heading' => 'Edit Note',
                'errors' => $errors,
                'note' => $note
            ]);
        }
        
        $this->db->query('UPDATE notes SET body = :body WHERE id = :id', [
            'id' => $_POST['id'],
            'body' => $_POST['body']
        ]);
        
        return $this->redirect('/notes');
    }
    
    public function destroy()
    {
        $note = $this->findNote($_POST['id']);
        
        $this->db->query('DELETE FROM notes WHERE id = :id', [
            'id' => $_POST['id']
        ]);
        
        return $this->redirect('/notes');
    }
    
    private function findNote($id)
    {
        $note = $this->db->query('SELECT * FROM notes WHERE id = :id', [
            'id' => $id
        ])->findOrFail();
        
        $this->authorize($note['user_id'] === $this->currentUserId());
        
        return $note;
    }
}