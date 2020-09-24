## Function `post_supports_amp`

> :warning: This function is deprecated: Use amp_is_post_supported() instead.

```php
function post_supports_amp( $post );
```

Determine whether a given post supports AMP.

### Arguments

* `\WP_Post $post` - Post.

### Return value

`bool` - Whether the post supports AMP.

### Source

:link: [includes/amp-helper-functions.php:874](/includes/amp-helper-functions.php#L874-L876)

<details>
<summary>Show Code</summary>

```php
function post_supports_amp( $post ) {
	return amp_is_post_supported( $post );
}
```

</details>