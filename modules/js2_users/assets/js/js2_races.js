jQuery(document).ready(function(){
  jQuery('a#js2_race_challenge').click(function(e){
    e.preventDefault();
    console.log(jQuery(this).attr('href'));
  });

  jQuery('select#race_amount').change(function(e){
    console.log(jQuery(this));
  });
});