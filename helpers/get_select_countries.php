<?php

function js2_helper_get_select_countries($inputname ="countries" ,$selected_value = null){

    $countries = array(
      "Albania", 
      "Armenia", 
      "Austria", 
      "Belgium Flemish", 
      "Belgium French", 
      "Bulgaria", 
      "Czech Republic",
      "Denmark",
      "Estonia",
      "Finland",
      "France",
      "Germany",
      "Greece",
      "Hungary",
      "Iceland",
      "Ireland",
      "Isle of Man",
      "Israel",
      "Italy",
      "Latvia",
      "Lithuania",
      "Luxembourg",
      "Macedonia",
      "Malta",
      "Moldova",
      "Netherlands",
      "Norway",
      "Poland",
      "Portugal",
      "Romania",
      "Russia",
      "Serbia",
      "Slovakia",
      "Spain",
      "Sweden",
      "Switzerland",
      "Turkey",
      "United Kingdom"
    );

    $returnstring = "<select name=\"$inputname\" id=\"$inputname\">";

    foreach ($countries as $country) {
      if($selected_value == $country){
        $returnstring .= "<option selected=\"selected\" value=\"$country\">$country</option>";
      } else {
        $returnstring .= "<option value=\"$country\">$country</option>";
      }
    }

    $returnstring .= "</select>";

    return $returnstring;

}