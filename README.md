# StatusLib

This is a library designed to demonstrate an [Laminas API Tools](https://api-tools.getlaminas.org/) "Code-Connected"
REST API, and has been written in parallel with the [Laminas API Tools documentation](https://github.com/laminas-api-tools/api-tools-documentation).

It uses the following components:

- [rhumsaa/uuid](https://github.com/ramsey/uuid), a library for generating and validating UUIDs.
- [laminas-api-tools/api-tools-configuration](https://github.com/laminas-api-tools/api-tools-configuration), used for providing PHP
  files as one possible backend for reading/writing status messages.
- [laminas/laminas-config](https://getlaminas.org/) for the actual configuration writer used
  by the `api-tools-configuration` module.
- [laminas/laminas-db](https://getlaminas.org/), used for providing a database table as a
  backend for reading/writing status messages.
- [laminas/laminas-stdlib](https://getlaminas.org/), specifically the Hydrator subcomponent,
  for casting data from arrays to objects, and for the `ArrayUtils` class, which provides advanced
  array merging capabilities.
- [laminas/laminas-paginator](https://getlaminas.org/) for providing pagination.

It is written as a Laminas module, but could potentially be dropped into other
applications; use the `StatusLib\*Factory` classes to see how dependencies might be injected.

## Installation

Use [Composer](https://getcomposer.org/) to install the library in your application:

```console
$ composer require laminas-api-tools/statuslib-example
```

If you are using this as part of a Laminas or Laminas API Tools application, you
may need to enable the module in your `config/application.config.php` file, if
you are not using the [laminas-component-installer](https://docs.laminas.dev/laminas-component-installer/):

```php
return [
    /* ... */
    'modules' => [
        /* ... */
        'StatusLib',
    ],
    /* ... */
];
```

## Configuration

When used as a Laminas module, you may define the following configuration values in order
to tell the library which adapter to use, and what options to pass to that adapter.

```php
[
    'statuslib' => [
        'db' => 'Name of service providing DB adapter',
        'table' => 'Name of database table within db to use',
        'array_mapper_path' => 'path to PHP file returning an array for use with ArrayMapper',
    ],
    'service_manager' => [
        'aliases' => [
            // Set to either StatusLib\ArrayMapper or StatusLib\TableGatewayMapper
            \StatusLib\Mapper::class => \StatusLib\ArrayMapper::class,
        ],
    ],
]
```

For purposes of the Laminas API Tools examples, we suggest the following:

- Create a PHP file in your application's `data/` directory named `statuslib.php` that returns an
  array:

  ```php
  <?php
  return [];
  ```

- Edit your application's `config/autoload/local.php` file to set the `array_mapper_path`
  configuration value to `data/statuslib.php`:

  ```php
  <?php
  return [
      /* ... */
      'statuslib' => [
        'array_mapper_path' => 'data/statuslib.php',
      ],
  ];
  ```

The above will provide the minimum necessary requirements for experimenting with the library in
order to test an API.

## Using a database

The file `data/statuslib.sqlite.sql` contains a [SQLite](https://www.sqlite.org/) schema. You can
create a SQLite database using:

```console
$ sqlite3 statuslib.db < path/to/data/statuslib.sqlite.sql
```

The schema can be either used directly by other databases, or easily modified to work with other
databases.


## StatusLib in a New Laminas  Project

1. Create a new Laminas project from scratch; we'll use `my-project` as our project folder:

  ```console
  $ composer create-project laminas/skeleton-application my-project
  ```

2. Install the StatusLib module:

  ```console
  $ composer require laminas-api-tools/statuslib-example
  ```

3. Build a DataSource

    - Option A: Array data source:

      First, copy the sample array to the `data` directory of thet application:

      ```console
      $ cp vendor/laminas-api-tools/statuslib-example/data/sample-data/array-data.php data/status.data.php
      ```

      Then, configure this datasource by setting up a `local.php` configuration file:

      ```console
      $ cp config/autoload/local.php.dist config/autoload/local.php
      ```

      Next, add the StatusLib specific configuration for an array based data source:

      ```php
      'statuslib' => [
         'array_mapper_path' => 'data/status.data.php',
      ],
      'service_manager' => [
          'aliases' => [
              \StatusLib\Mapper::class => \StatusLib\ArrayMapper::class,
          ],
      ],
      ```

    - Option B: Sqlite data source:

      First, create a sqlite3 database, and fill it with the sample data:

      ```console
      $ sqlite3 data/status.db < vendor/laminas-api-tools/statuslib-example/data/statuslib.sqlite.sql
      $ sqlite3 data/status.db < vendor/laminas-api-tools/statuslib-example/data/sample-data/db-sqlite-insert.sql
      ```
  
      Then, configure this datasource by setting up a `local.php` configuration file:

      ```console
      $ cp config/autoload/local.php.dist config/autoload/local.php
      ```

      Next, add the StatusLib specific configuration for a sqlite database based data source:

      ```php
      'db' => [
          'adapters' => [
              'MyDb' => [
                  'driver' => 'pdo_sqlite',
                  'database' => __DIR__ . '/../../data/status.db'
              ],
          ],
      ],
      'statuslib' => [
          'db' => 'MyDb',
          'table' => 'status',
      ],
      'service_manager' => [
          'aliases' => [
              \StatusLib\Mapper::class => \StatusLib\TableGatewayMapper::class,
          ],
      ],
      ```

4. Create a test script to prove the data source is working:

   ```php
   // test.php
   namespace StatusLib;

   use Laminas\Mvc\Application;
   use Laminas\Stdlib\ArrayUtils;

   include 'vendor/autoload.php';

   $appConfig = include 'config/application.config.php';

   if (file_exists('config/development.config.php')) {
       $appConfig = ArrayUtils::merge(
           $appConfig,
           include 'config/development.config.php'
       );
   }

   $app = Application::init($appConfig);
   $services = $app->getServiceManager();

   $statusMapper = $services->get(Mapper::class);
   foreach ($statusMapper->fetchAll() as $status) {
       printf(
           "[%d] [%s] %s (by %s)\n",
           $status->timestamp,
           $status->id,
           $status->message,
           $status->user
       );
   }
   ```
