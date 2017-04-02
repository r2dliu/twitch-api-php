# Bits API

- [getCheermotes](#getcheermotes)

## getCheermotes

<table>
    <tr>
    	<th>Description</th>
    	<td>Get a list of cheermotes. Add an optional channel ID as the first parameter to return both the generic emotes as well as any channel specific cheer emotes.</td>
    </tr>
    <tr>
    	<th>Supported API Versions</th>
    	<td>v5</td>
    </tr>
    <tr>
    	<th>Required Scope</th>
    	<td>None</td>
    </tr>
    <tr>
    	<th>Parameters</th>
    	<td>&bull; channelIdentifier <i>(optional)</i></td>
    </tr>
</table>

Example 1:

```php
$twitchApi = new TwitchApi($options);
$twitchApi->getCheermotes();
```

Example 2:

```php
$twitchApi = new TwitchApi($options);
$twitchApi->getCheermotes(26490481); // with channel ID
```
