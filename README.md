Installation
============

### Download the Bundle

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

```console
$ composer require shanbo/immo
```

Update database + create User entity

```console
$ php bin/console do:sc:up -f
```

Insert ZIP in public/data/depot and then run command

```console
$ php bin/console shanbo:immo
```
