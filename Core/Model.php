<?php
// Core/Model.php

namespace Core;

abstract class Model
{
    protected static $table;
    protected static $primaryKey = 'Id';
    
    protected static function db()
    {
        return App::resolve(Database::class);
    }
    
    public static function all()
    {
        return static::db()->query("SELECT * FROM " . static::$table)->get();
    }
    
    public static function find($id)
    {
        return static::db()->query(
            "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id", 
            ['id' => $id]
        )->find();
    }
    
    public static function where($column, $value)
    {
        return static::db()->query(
            "SELECT * FROM " . static::$table . " WHERE {$column} = :value",
            ['value' => $value]
        )->get();
    }
    
    public static function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        return static::db()->query(
            "INSERT INTO " . static::$table . " ({$columns}) VALUES ({$placeholders})",
            $data
        );
    }
    
    public static function update($id, $data)
    {
        $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $data['id'] = $id;
        
        return static::db()->query(
            "UPDATE " . static::$table . " SET {$setClause} WHERE " . static::$primaryKey . " = :id",
            $data
        );
    }
    
    public static function delete($id)
    {
        return static::db()->query(
            "DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id",
            ['id' => $id]
        );
    }
}