# jsondb2
A Simplied ORM for Json PHP DB flat file

#### 

This is a simple 1 page I used to replace jsondb 1. 

## insert ()

Automatically Adds Rows 

```
$db = new JsonDB('data.json');

$data = ['steve','john'];
$db->insert($data);
```

## delete () 

## Find ($field,$value)
Returns An Array 

`$db->find($field,value)` 

## FindAll($toArray)
Returns An Array of Objects

`$db->findAll()` 
