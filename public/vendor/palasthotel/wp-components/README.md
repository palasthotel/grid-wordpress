# WP Components

This composer library provides php class helpers for typical WordPress extensions. Version number reads as `MAJOR.FEATURE.BUGFIX` which means:

- BUGFIX: only internal bugfix or performance optimizations. No new stuff
- FEATURE: something new has been added
- MAJOR: something was changed that could break

MAJOR version updates will be separated to a new versions namespace so they can be used in parallel to older versions.

## Get started

Add the following to your composer.json

```json
{
  ...,
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/palasthotel/wp-components.git"
    }
  ],
  "require": {
    "palasthotel/wp-components": "0.1.0"
  },
  ...
}
```

Then use `composer install` to install the dependencies. Use `composer install --no-cache` if you use dev version `"palasthotel/wp-components": "dev-master"`.

Include the generated `vendor/autoload.php` to use autoload.

## Plugin

Extend the abstract class Plugin.

```php
class MyPlugin extends \Palasthotel\WordPress\Plugin {
    public function onCreate(){
        // you must implement onCreate function
        // this is where you build your plugin components
        
        // (optional) language path settings
        $this->textdomainConfig = new \Palasthotel\WordPress\Config\TextdomainConfig(
            "my-plugin-domain", // the text domain of your plugin
            "languages" // relative path in your plugin directory
        );
    }
    
    public function onActivation($networkWide){
        parent::onActivation($networkWide);
        // you can overwrite onActivation
        // better use onSiteActivation
    }
    
    public function onSiteActivation(){
        // you can overwrite onSiteActivation
        // this will be called for every site if plugin get activate network wide
        // this also works with single site setups
    }
    
    public function onDeactivation($networkWide){
        parent::onDeactivation($networkWide);
        // you can overwrite onDeactivation
        // better use onSiteDeactivation
    }
    
    public function onSiteDeactivation(){
        // you can overwrite onDeactivation function
        // this will be called for every site if plugin get deactivate network wide
        // this also works with single site setups
    }
}
MyPlugin::instance();
```
This Plugin class automatically has some properties like `path`, `url` and `basename` and holds the singleton instance.

## Database

Use the abstract class Database.

```php
class MyDatabase extends \Palasthotel\WordPress\Database {
    public function init(){
        $this->table = $this->wpdb->prefix."my_table";
    }
    
    // implement query and manipulation functions
    
    public function createTables(){
        parent::createTables(); 
        dbDelta("CREATE TABLE QUERY");
    }
}
```

## Assets

Register javascript or style assets. This will automagically use dependency management via _script_.asset.php file if exists or use `filemtime` for proper versioning instead.

```php

class Assets extends \Palasthotel\WordPress\Assets {

    function onEnqueue(bool $isAdmin,string $hook){
        parent::onEnqueue($isAdmin, $hook);
        $this->registerScript("my-script-handle","js/my-file.js");
        $this->registerStyle("my-style-handle", "css/my-file.css");
        
        // call wp_enqueue_(script/style) directly or somewhere else
        wp_enqueue_script("my-script-handle");
        wp_enqueue_style("my-style-handle");
    }
    
    function onAdminEnqueue(string $hook){
        parent::onAdminEnqueue($hook);
        // for all scripts and styles that need to be enqueued for /wp-admin useage
    }
    
    function onPublicEnqueue(string $hook){
        parent::onPublicEnqueue($hook);
        // for all scripts and styles that need to be enqueue everywhere but not /wp-admin
    }
}




```
## Attachment Meta Field

Use these classes if you want to add some meta fields to attachments.

### TextMetaField

```php
$field = \Palasthotel\WordPress\Attachment\TextMetaField::build("my_meta_key")
->label("My label")
->help("Some helping hint");
```

The value will be saved to `my_meta_key` post meta. It can be accessed by with `$field->getValue($attachment_id);` and set with `$field->setValue($attachment_id, $value)`.

Saving and providing values can be customized.

```php
class MyStore implements \Palasthotel\WordPress\Service\StoreInterface {
    public function set($id,$value){
     // save the value however you like
    }
    public function get($id){
     // get the value and return it
    }
    public function delete($id){
      // delete value
    }
}
$field->useStore(new MyStore());
```

### TextareaMetaField

This class is working exactly like TextMetaField.

### SelectMetaField

```php
$field = \Palasthotel\WordPress\Attachment\SelectMetaField::build("my_meta_key")
->label("My label")
->help("Some helping hint")
->options([
    \Palasthotel\WordPress\Model\Option::build("","-nothing selected-"),
    \Palasthotel\WordPress\Model\Option::build("1","One"),
    \Palasthotel\WordPress\Model\Option::build("2","Two"),
]);
```

Getter, setter and useStore functions are working exactly like TextMetaField.

## TermMetaFields

Use these classes if you want to add some term meta fields.

### TermMetaInputField

```php
$taxonomies = ["category", "post_tag"];
$field = \Palasthotel\WordPress\Taxonomy\TermMetaInputField::build("my_meta_key", $taxonomies)
->label("My label")
->description("Some description")
->type("number");
```

The value will be saved to `my_meta_key` term meta. It can be accessed by with `$field->getValue($term_id);` and set with `$field->setValue($term_id, $value)`.

Saving and providing values can be customized.

```php
class MyStore implements \Palasthotel\WordPress\Service\StoreInterface {
    public function set($id,$value){
     // save the value however you like
    }
    public function get($id){
     // get the value and return it
    }
    public function delete($id){
      // delete value
    }
}
$field->useStore(new MyStore());
```

#### TermMetaCheckboxField

```php
$taxonomies = ["category", "post_tag"];
$field = \Palasthotel\WordPress\Taxonomy\TermMetaCheckboxField::build("my_meta_key",$taxonomies)
->label("My label")
->description("Some description")
->truthyValue("yes");
```

Getter, setter and useStore functions are working exactly like TermMetaInputField.

You can access checked boolean state with `$field->isChecked($term_id)`.

## Posts table

### Add Column

```php
$column = \Palasthotel\WordPress\PostsTable\Column::build("my_col_id");

// add a column label
$column->label("My Label");

// add a render function for column contents
$column->render(function($post_id){
    echo "<p>my column content</p>";
});

// add column after title column
$column->after("title");
// add your column before title column
$column->before("title");

// add column only for these post types
$column->postTypes(["my_post_type"]);

// or implement ProviderInterface to wait for filter be ready 
class MyPostTypesProvider implements \Palasthotel\WordPress\Service\ProviderInterface {
    public function get(){
        return apply_filters("my_post_types_filter", []);
    }
}
$column->postTypes(new MyPostTypesProvider());
```