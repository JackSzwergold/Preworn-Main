$(document).ready(function() {

  // This de-selects a checked element after a predetermined period of time.
  function deselectElement(element_selector, delay) {
    var delay = ((typeof delay !== 'undefined') ? delay : 1800);
    $(element_selector).change(function(){
      $(this).delay(delay).queue(function() {
        $(this).prop("checked", false).dequeue();
      });
    });
  }

  // This iterates through the list of inputs and checks each element.
  function iterateElements(element_selector, iteration) {
    var iteration = ((typeof iteration !== 'undefined') ? iteration : 900);
    var delay = iteration;
    $(element_selector).each(function(new_index) {
      var element = $(this);
      setTimeout( function(){
        $(element).prop('checked', !$(element).attr('checked'));
      }, delay);
      delay += iteration;
    }).promise().done(function() {
      setTimeout(function() {
        iterateElements(element_selector, iteration);
      }, delay -= iteration);
    });
  }

  //////////////////////////////////////////////////////////////////////////////
  // TODO: Touch tests.

  //////////////////////////////////////////////////////////////////////////////
  // This calculates a new index value.
  function directionalIndexValue(clicked_side, new_index, limit, loop) {

    var new_index = ((typeof new_index !== 'undefined') ? new_index : 1);
    var limit = ((typeof limit !== 'undefined') ? limit : 5);
    var clicked_side = ((typeof clicked_side !== 'undefined') ? clicked_side : true);
    var loop = ((typeof loop !== 'undefined') ? loop : false);

    if (clicked_side) {

      // Swipe right.
      if (loop) {
        new_index = (new_index + 1) % (limit + 1);
        if (new_index == 0) {
          new_index = new_index += 1;
        }
      }
      else {
        new_index = new_index + 1;
        if (new_index >= limit) {
          new_index = limit;
        }
      }

    }
    else {

      // Swipe left.
      if (loop) {
        new_index = (new_index + limit - 1) % limit;
        if (new_index <= 0) {
          new_index = limit;
        }
      }
      else {
        new_index = new_index - 1;
        if (new_index <= 0) {
          new_index = 1;
        }
      }

    }
    return Math.abs(new_index);
  }

  //////////////////////////////////////////////////////////////////////////////
  // This determines what side of an element was clicked.
  function clickedSide(event, element) {
    return event.center.x >= (element.offset().left + element.width()/2) ? true : false;
  }

  //////////////////////////////////////////////////////////////////////////////
  // Hammer specific stuff.

  var hammer_instance = new Hammer($('div.wrapper div.container')[0]);
  hammer_instance.on('swipeleft swiperight', function(event) {

    // Set some variables.
    new_index = ((typeof new_index !== 'undefined') ? new_index : 0);
    element_index = ((typeof element_index !== 'undefined') ? element_index : 1);
    var limit = $('div.wrapper div.container > div.element').length;

    // Stuff to do depending on interaction type.
    if (event.type == 'swipeleft') {
      new_index = directionalIndexValue(true, new_index, limit, false);
    }
    if (event.type == 'swiperight') {
      new_index = directionalIndexValue(false, new_index, limit, false);
    }
    // if (event.type == 'press') {
    //   var element_index = $(event.target).closest('div.element').index();
    //   new_index = Math.abs(element_index + 1);
    // }
    // if (event.type == 'tap') {
    //   var clicked_side = clickedSide(event, $(event.target).closest('div.element'));
    //   new_index = directionalIndexValue(clicked_side, new_index, limit, true);
    // }

    // Determine the control elemement and toggle the 'checked' value of the control element.
    var control_element = $('div.wrapper input[type=radio][id="element_' + new_index + '"]');
    control_element.prop('checked', true);

    // Log stuff for debugging.
    console.log(event.type + ' | new_index: ' + new_index + ' | limit: ' + limit);

  });

  // Different ways to call the functions.
  // deselectElement('div.wrapper [id*="element_"]', 600);
  // iterateElements('div.wrapper input[type=checkbox][id*="element_"]', 600);
  // iterateElements('div.wrapper input[type=radio][id*="element_"]', 600);
  // iterateElements('body input[type=checkbox][id*="wrapper_"]', 1800);

});
