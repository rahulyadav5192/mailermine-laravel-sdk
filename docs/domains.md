# Domains

Manage sending domains and DNS verification with `domains()`.

## Create

```php
$domain = $mm->domains()->create([
    'domain' => 'mail.example.com',
]);

$id = $domain->data()['id'];
```

## DNS records

```php
foreach ($mm->domains()->dnsRecords($id) as $record) {
    echo "{$record['type']} {$record['name']} {$record['value']}\n";
}
```

Add the returned records at your DNS provider, then verify:

```php
$status = $mm->domains()->verify($id);
echo $status->data()['status'];
```

## List and status

```php
$mm->domains()->list(['status' => 'verified']);
$mm->domains()->status($id);
$mm->domains()->get($id);
$mm->domains()->delete($id);
```

## Example

See [`examples/verify-domain.php`](../examples/verify-domain.php).
