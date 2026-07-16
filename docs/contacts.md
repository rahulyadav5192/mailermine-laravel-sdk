# Contacts

Manage subscribers with `contacts()`, plus lists, segments, and tags.

## Create and upsert

```php
$contact = $mm->contacts()->upsert([
    'email'      => 'john@example.com',
    'first_name' => 'John',
    'last_name'  => 'Doe',
    'subscribed' => true,
    'custom_fields' => ['plan' => 'pro'],
]);

$id = $contact->data()['id'];
```

## Update and subscription state

```php
$mm->contacts()->update($id, ['last_name' => 'Appleseed']);
$mm->contacts()->subscribe($id);
$mm->contacts()->unsubscribe($id);
```

## List and search

```php
$contacts = $mm->contacts()->list([
    'subscribed' => true,
    'page'       => 1,
    'per_page'   => 25,
]);

foreach ($contacts as $contact) {
    echo $contact['email'];
}

$mm->contacts()->search('john');
```

## Lists

```php
$list = $mm->lists()->create(['name' => 'Newsletter']);
$mm->lists()->addContact($list->data()['id'], $id);
```

## Segments

```php
$segment = $mm->segments()->create([
    'name'  => 'Active subscribers',
    'rules' => [
        'logic' => 'and',
        'rules' => [
            ['field' => 'subscribed', 'operator' => 'equals', 'value' => true],
        ],
    ],
]);

$mm->segments()->preview($segment->data()['id']);
```

## Tags

```php
$tag = $mm->tags()->create(['name' => 'vip']);
$mm->tags()->assign([
    'contact_ids' => [$id],
    'tag_ids'     => [$tag->data()['id']],
]);
```

## Imports

```php
$import = $mm->imports()->create(['file' => '/path/to/contacts.csv']);
$mm->imports()->configure($import->data()['id'], [
    'field_mappings' => ['email' => 'email', 'first_name' => 'first_name'],
    'duplicate_strategy' => 'update',
]);
$mm->imports()->start($import->data()['id']);
```

## Examples

- [`examples/contacts.php`](../examples/contacts.php)
- [`examples/import-contacts.php`](../examples/import-contacts.php)
