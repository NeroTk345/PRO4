<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 22;
//Lets find the corresponding note
    $note = $db->query('SELECT * from notes where id = :id', [
        'id' => $_POST['id']
    ])->findOrFail();

//authorize that the current note can edit the note
authorize($note['user_id'] === $currentUserId);

// validate the form
$errors = [];

 if (!Validator::string($_POST['body'], 1, 10)) {
        $errors['body'] = 'A body of no more than 1,000 characters is required.';
    }

// if no validation errors, update the the record in the notes database table
if (count($errors)) {
    return view('notes/edit.view.php', [
        'heading' => 'Edit note',
        'errors' => $errors,
        'note' => $note
    ]);
}

        $db->query('UPDATE notes SET body = :body WHERE id = :id', [
            'id' => $_POST['id'],
            'body' => $_POST['body']
        ]);

        //redirect the user
        header('location: /notes');
        die();
   