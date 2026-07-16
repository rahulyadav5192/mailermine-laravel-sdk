# Templates

Reusable email templates via `templates()`.

## Create

```php
$template = $mm->templates()->create([
    'name'    => 'Welcome Email',
    'subject' => 'Welcome {{first_name}}',
    'html'    => '<h1>Welcome {{first_name}}!</h1>',
    'text'    => 'Welcome {{first_name}}!',
]);

$id = $template->data()['id'];
```

## Preview, update, duplicate

```php
$mm->templates()->preview($id, ['first_name' => 'John']);
$mm->templates()->update($id, ['subject' => 'Hey {{first_name}}']);
$mm->templates()->duplicate($id, ['name' => 'Welcome (copy)']);
```

## Send with a template

```php
$mm->emails()->send([
    'from'        => 'hello@mailermine.com',
    'to'          => 'john@example.com',
    'template_id' => $id,
    'variables'   => ['first_name' => 'John'],
]);
```

## List and delete

```php
$mm->templates()->list(['search' => 'welcome']);
$mm->templates()->get($id);
$mm->templates()->delete($id);
```

## Example

See [`examples/create-template.php`](../examples/create-template.php).
