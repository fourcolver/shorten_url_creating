1. Installation.

  1) DB install
    Need to import sql to database.
    Database name should be "shorten_test".
  2) Configuration
    Need to update some variable in dbconfig.php.
    $DB_host
    $DB_user
    $DB_pass
    $DB_name 
    These 4 variables should be updated according to the database configuration.

2. Adding origin url to get the shorten url
  From the first page(index.php), need to enter the origin url to be shorten.
  Then click the submit button to get the shorten url.
  * the origin url should be valid.

3. View for the often accessed url.
  In the first view(index.php), you can see the table content that accessed more often(100 urls).
  
4. The endpoint to get the more often accessed top 100 urls.
  /api
  this will help to see the restful api to see the 100 urls that are accessed more often.
  for example.
  if the project is placed in https://test.com/
  then endpoint url is https://github.com/api
  
  :)
