# MehrIT LaraExt - Collection of helpers and macros for laravel

This library adds commonly used helpers and macros to the Laravel PHP framework.

So far this includes:

* Collection macros
* String macros
* Additional helpers

It also includes a helper file for IDE auto completion.

## Installation

Install via composer:

    composer require mehr-it/lara-ext

This package uses Laravel's auto package detection

## Collection macros

Following macros extend the `Illuminate\Support\Collection`:

| Macro              | Description
|--------------------| ------------
| `diffBy`           | `array_diff()` with custom comparator
| `diffAssocBy`      | associative `array_diff()` with custom comparators
| `sortCallback`     | sort using custom sort function
| `sortCallbackDesc` | sort in descending order using custom sort function
| `asKeys`           | `array_fill_keys()` for collections

## Array macros

Following macros extend the `Illuminate\Support\Arr`:

| Macro                      | Description
|----------------------------| ------------
| `hasSameKeysAndValues`     | Recursively checks if both arrays have same key value pairs. The order of associative key/value pairs does not matter.

## String macros

Following macros extend the `Illuminate\Support\Str`:

| Macro              | Description
|--------------------| ------------
| `cast`             | Casts given value as string. If iterable is given, it's items are casted as string
| `cutEncoding`      | truncates a string, so it does not exceed a given byte length, when converted to a given target encoding
| `extract`          | as explode but guarantees a given result array length, eg.: `[$a, $b] = Str::extract('a:b:c', ':', 2)`
| `isEmpty`          | returns if the given string is empty or only contains whitespace
| `isNotEmpty`       | returns if the given string is not empty and does not only contains whitespace
| `replaceLineBreaks`| replaces all line breaks (Linux, Windows and Mac (old and OS X)) in a string
| `ucFirstWords`     | converts the first letter of each word to uppercase
| `repairInvalidUnicodeSequences`     | replaces invalid unicode sequences
| `limitMax`         | limits a string to the given max length

## Helpers

| Helper             | Description
|--------------------| ------------
| `buffer`           | creates a new `FlushingBuffer` instance
| `chunked`          | `array_chunk()` for generators
| `chunked_generator`| Processes data from a generator in chunks and returns a generator with the processed data
| `cursor_get`       | `data_get()` for iterators
| `group_by_consecutive` | groups data by given field (requires consecutive order of group values)
| `iterator_for`     | gets an iterator for the given value
| `joined`           | joins two collections and passes the tuples to a callback
| `mapped`           | `array_map()` for generators
| `trans_default`    | like `trans()` but returning a given default value if not translatable 
| `type_name`        | returns the class name or the type of the given variable 
| `with_locale`      | sets the specified app locale for the given callback 


## Helpers

### buffer()

Flushing buffers implement buffers with a given size which are automatically flushed using a given handler function when they are full.

You may create an instance using the `buffer`-helper. It Takes up to three arguments:

	buffer(10, function(data) { /* send data */ });
	buffer(10, function(data) { /* send data */ }, function() { return collect(); });

The first argument specifies the buffer size, the second one a handler function which is called each time the buffer is full. It receives the buffer data as argument. The third one is optional and acts as resolver for the underlying data structure to use. If omitted a simple array is used.

New items are added to the buffer using the `add()`-method. Usually you want the buffer to be flushed a last time, after all data was added, even if it's not full. To achieve this, simply call the `flush()`-method to manually flush the buffer:

	$b = buffer(2, function(data) { /* send data */ });
	$b->add(1);
	$b->add(2);
	$b->add(3);
	$b->flush();

You may also specify a key, if you want to replace elements in the buffer at given key.

	$b = buffer(2, function(data) { /* send data */ });
	$b->add(1, 'key1');
	$b->add(2, 'key1');

Of course replacing and existing element does not increase buffer size and therefore does not cause a buffer flush.

### chunked()

The native `array_chunk()`-function is very useful when dealing with large data that cannot be processed at once. However it does not solve the problem that you might not even be able to load all the input data at once. Here the `chunked()`-helper function - which also accepts generators - comes in. See following example:

	$generator = function() { /* generator code */ };
	
	chunked($generator, 500, function($chunk) {
		/* processing code */
	});

### chunked_generator()

The `chunked_generator()`-function is very similar to the `chunked()`-function but returns a generator which yields all generators returned by the handler.

	$in = function() { /* input generator code */ };

	$generator = chunked_generator($in, 500, function($chunk) {
		yield /* ... */
	});

### cursor_get()

The `cursor_get()` helper iterates the passed items (cursor, collection, array, ...) and uses `data_get()` to receive a value for each item which will be returned by the returned generator. You may also pass a closure as field parameter which returns the value for each item:

	$data = [
		['x' => ['y' => 7]],
		['x' => ['y' => 8]],
	];
	
	foreach(cursor_get($data, 'x.y') as $v) {
		echo $v;
	}
	// => 7
	// => 8

### group_by_consecutive()

The `group_by_consecutive()` helper groups data from given iterator or array by a given key. A new group is started as soon as an item's group value does not match the last item's group value. Therefore same group values must occur consecutively in the input for correct output grouping. Group values are compared using strict comparison.

	$data = [ ['x' => 15, 'y' => 'a'], ['x' => 16, 'y' => 'a'], ['x' => 17, 'y' => 'b'] ];

	$iter = group_by_consecutive($data, 'y');
	
	// => [ ['x' => 15, 'y' => 'a'], ['x' => 16, 'y' => 'a'] ]
	// => [ ['x' => 17, 'y' => 'b'] ]

### iterator_for()

The `iterator_for()` helper creates an iterator for the given value. Iterators are returned as they are, for arrays an ArrayIterator is returned and all other values are returned as the first item of an array iterator, if they are not null. Passing null will return an EmptyIterator.

	$iter = iterator_for(['a', 'b']);

### joined()

Often you have to join two collections by a given field and want to process the joined value pairs. The `joined()` helper makes this task really easy:

	joined($collectionA, 'fieldA', $collectionB, 'fieldB.x', function($a, $b) {
		/* do s.th. here */
	});

The closure receives the value pairs. By default only the first matching value pair is processed. But you may specify this by a parameter.

This helper is very flexible. You may pass in generators, closures, any traversables and even model names:

	joined($collectionA, 'user', User::class, 'username', function($a, $b) {
		/* do s.th. here */
	});

This would call `User::whereIn('username', /* .. */)->get()` to receive the right side collection. If you need more flexibility you can pass a query builder:

	joined($collectionA, 'user', User::where('active', true), 'username', function($a, $b) {
		/* do s.th. here */
	});

### mapped()

The `mapped()`-function behaves like the `array_map()`-function but may also be used with generators:

	$generator = function() { /* generator code */ };
	
	$mappedGenerator = mapped($generator, function($v) { /* mapping code */ });

### trans_default()

The `trans_default()` helper extends the `trans()` helper by the ability to add a default value which is used, if the value cannot be translated. If a translation exists at the fallback locale, it still takes precedence over the default value.

    trans_default('app.myTranslationKey', 'The default value');


### type_name()

The `type_name()` helper returns the class name of the given variable. If the variable is
not an object, the type (as returned by `gettype()`, but always lowercase) will be returned

    type_name(new MyClass());
    // => 'MyClass'

    type_name('a');
    // => 'string'

    type_name(null);
    // => 'null'

### with_locale()

The `with_locale()` helper temporarily sets the application locale to a specified value
and reverts it after return of the given callback:

    // locale is 'en'

    with_locale('de', function() {

        // locale is 'de'

    });

    // locale is 'en'


## Migrating from its-mieger/lara-ext

This package replaces the abandoned `its-mieger/lara-ext` 
package. However some functionality is removed in 
this package:

* data_get is not overwritten anymore, so getters are not recognized anymore

The following helpers are removed (See package [mehr-it/lara-db-ext](https://packagist.org/packages/mehr-it/lara-db-ext) which implements their functionality):
* db_quote_identifier
* db_table
* db_table_raw
* db_connection
* db_field
* db_field_raw

The following collection macros are removed, because they 
are abstracting another package's functionality which is
not in the scope of this library:

* diffObj
* diffAssocObj
* sortObjDesc
* compareToValues
* compareToValuesAssoc
* maxBy
* minBy