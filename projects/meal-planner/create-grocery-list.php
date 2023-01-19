<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the ingredients from the form
  $monday_breakfast_ingredients = $_POST['monday-breakfast-ingredients'];
  $monday_lunch_ingredients = $_POST['monday-lunch-ingredients'];
  $monday_dinner_ingredients = $_POST['monday-dinner-ingredients'];
  $tuesday_breakfast_ingredients = $_POST['tuesday-breakfast-ingredients'];
  $tuesday_lunch_ingredients = $_POST['tuesday-lunch-ingredients'];
  $tuesday_dinner_ingredients = $_POST['tuesday-dinner-ingredients'];
  $wednesday_breakfast_ingredients = $_POST['wednesday-breakfast-ingredients'];
  $wednesday_lunch_ingredients = $_POST['wednesday-lunch-ingredients'];
  $wednesday_dinner_ingredients = $_POST['wednesday-dinner-ingredients'];
  $thursday_breakfast_ingredients = $_POST['thursday-breakfast-ingredients'];
  $thursday_lunch_ingredients = $_POST['thursday-lunch-ingredients'];
  $thursday_dinner_ingredients = $_POST['thursday-dinner-ingredients'];
  $friday_breakfast_ingredients = $_POST['friday-breakfast-ingredients'];
  $friday_lunch_ingredients = $_POST['friday-lunch-ingredients'];
  $friday_dinner_ingredients = $_POST['friday-dinner-ingredients'];

  // Create an array to store all the ingredients
  $ingredients = array();

  // Add the ingredients to the array
  $ingredients[] = $monday_breakfast_ingredients;
  $ingredients[] = $monday_lunch_ingredients;
  $ingredients[] = $monday_dinner_ingredients;
  $ingredients[] = $tuesday_breakfast_ingredients;
  $ingredients[] = $tuesday_lunch_ingredients;
  $ingredients[] = $tuesday_dinner_ingredients;
  $ingredients[] = $wednesday_breakfast_ingredients;
  $ingredients[] = $wednesday_lunch_ingredients;
  $ingredients[] = $wednesday_dinner_ingredients;
  $ingredients[] = $thursday_breakfast_ingredients;
  $ingredients[] = $thursday_lunch_ingredients;
  $ingredients[] = $thursday_dinner_ingredients;
  $ingredients[] = $friday_breakfast_ingredients;
  $ingredients[] = $friday_lunch_ingredients;
  $ingredients[] = $friday_dinner_ingredients;

  // Create an array of categories
  $categories = array('Produce', 'Meat', 'Bakery', 'Dairy', 'Canned Goods', 'Other');

  // Create an array for each category
  $produce = array();
  $meat = array();
  $bakery = array();
  $dairy = array();
  $canned_goods = array();
  $other = array();

  // Determine the category for each ingredient and add it to the appropriate array
  foreach ($ingredients as $ingredient) {
  if (preg_match('/\b(apple|banana|orange|tomato|lettuce|potato)\b/i', $ingredient)) {
    $produce[] = $ingredient;
    } elseif (preg_match('/\b(beef|chicken|pork|sausage|bacon)\b/i', $ingredient)) {
      $meat[] = $ingredient;
    } elseif (preg_match('/\b(bread|roll|muffin|cake)\b/i', $ingredient)) {
      $bakery[] = $ingredient;
    } elseif (preg_match('/\b(milk|cheese|yogurt|cream)\b/i', $ingredient)) {
      $dairy[] = $ingredient;
    } elseif (preg_match('/\b(can|tuna|soup|beans)\b/i', $ingredient)) {
      $canned_goods[] = $ingredient;
    } else {
      $other[] = $ingredient;
    }
  }

  // Create an array to store the organized ingredients
  $organized_ingredients = array();

  // Add the ingredients from each category to the organized ingredients array
  foreach ($categories as $category) {
    switch ($category) {
      case 'Produce':
        $organized_ingredients = array_merge($organized_ingredients, $produce);
        break;
      case 'Meat':
        $organized_ingredients = array_merge($organized_ingredients, $meat);
        break;
      case 'Bakery':
        $organized_ingredients = array_merge($organized_ingredients, $bakery);
        break;
      case 'Dairy':
        $organized_ingredients = array_merge($organized_ingredients, $dairy);
        break;
      case 'Canned Goods':
        $organized_ingredients = array_merge($organized_ingredients, $canned_goods);
        break;
      case 'Other':
        $organized_ingredients = array_merge($organized_ingredients, $other);
        break;
    }
  }

  // Use implode() to join all the ingredients in the array into a single string
  $ingredients_string = implode("\n", $organized_ingredients);

  // Display the ingredients to the user
  echo '<h2>Produce</h2>';
  echo '<ul>';
  foreach ($produce as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';

  echo '<h2>Meat</h2>';
  echo '<ul>';
  foreach ($meat as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';

  echo '<h2>Bakery</h2>';
  echo '<ul>';
  foreach ($bakery as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';

  echo '<h2>Dairy</h2>';
  echo '<ul>';
  foreach ($dairy as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';

  echo '<h2>Canned Goods</h2>';
  echo '<ul>';
  foreach ($canned_goods as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';

  echo '<h2>Other</h2>';
  echo '<ul>';
  foreach ($other as $item) {
    echo '<li>' . $item . '</li>';
  }
  echo '</ul>';
  }
?>
