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
    $(element_selector).each(function(index_value) {
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
  function directionalIndexValue(clicked_side, index_value, limit, loop) {

    var index_value = ((typeof index_value !== 'undefined') ? index_value : 1);
    var limit = ((typeof limit !== 'undefined') ? limit : 5);
    var clicked_side = ((typeof clicked_side !== 'undefined') ? clicked_side : true);
    var loop = ((typeof loop !== 'undefined') ? loop : false);

    if (clicked_side) {

      // Swipe right.
      if (loop) {
        index_value = (index_value + 1) % (limit + 1);
        if (index_value == 0) {
          index_value = index_value += 1;
        }
      }
      else {
        index_value = index_value + 1;
        if (index_value >= limit) {
          index_value = limit;
        }
      }

    }
    else {

      // Swipe left.
      if (loop) {
        index_value = (index_value + limit - 1) % limit;
        if (index_value <= 0) {
          index_value = limit;
        }
      }
      else {
        index_value = index_value - 1;
        if (index_value <= 0) {
          index_value = 1;
        }
      }

    }
    return Math.abs(index_value);
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
    event_index = $(event.target).closest('div.element').index();
    if (event_index >= 0) {
      index_value = event_index + 1;
    }
    if (typeof index_value == 'undefined') {
      index_value = 0;
    }
    // element_index = ((typeof element_index !== 'undefined') ? element_index : 1);
    var limit = $('div.wrapper div.container > div.element').length;

    // Stuff to do depending on interaction type.
    if (event.type == 'swipeleft') {
      index_value = directionalIndexValue(true, index_value, limit, false);
    }
    if (event.type == 'swiperight') {
      index_value = directionalIndexValue(false, index_value, limit, false);
    }
    // if (event.type == 'press') {
    //   var element_index = $(event.target).closest('div.element').index();
    //   index_value = Math.abs(element_index + 1);
    // }
    // if (event.type == 'tap') {
    //   var clicked_side = clickedSide(event, $(event.target).closest('div.element'));
    //   index_value = directionalIndexValue(clicked_side, index_value, limit, true);
    // }

    // Determine the control elemement and toggle the 'checked' value of the control element.
    var control_element = $('div.wrapper input[type=radio][id="element_' + index_value + '"]');
    control_element.prop('checked', true);

    // Log stuff for debugging.
    // console.log(event.type + ' | index_value: ' + index_value + ' | limit: ' + limit);

  });

  // Different ways to call the functions.
  // deselectElement('div.wrapper [id*="element_"]', 600);
  // iterateElements('div.wrapper input[type=checkbox][id*="element_"]', 600);
  // iterateElements('div.wrapper input[type=radio][id*="element_"]', 600);
  // iterateElements('body input[type=checkbox][id*="wrapper_"]', 1800);

});
