<<<<<<< HEAD
module('Accessibility - Search');

var MultipleSelection = require('select2/selection/multiple');
var InlineSearch = require('select2/selection/search');

var $ = require('jquery');

var Utils = require('select2/utils');
var Options = require('select2/options');
var options = new Options({});

test('aria-autocomplete attribute is present', function (assert) {
  var $select = $('#qunit-fixture .multiple');

  var CustomSelection = Utils.Decorate(MultipleSelection, InlineSearch);
  var selection = new CustomSelection($select, options);
  var $selection = selection.render();

  // Update the selection so the search is rendered
  selection.update([]);

  assert.equal(
    $selection.find('input').attr('aria-autocomplete'),
    'list',
    'The search box is marked as autocomplete'
  );
});

test('aria-activedescendant should be removed when closed', function (assert) {
  var $select = $('#qunit-fixture .multiple');

  var CustomSelection = Utils.Decorate(MultipleSelection, InlineSearch);
  var selection = new CustomSelection($select, options);
  var $selection = selection.render();

  var container = new MockContainer();
  selection.bind(container, $('<span></span>'));

  // Update the selection so the search is rendered
  selection.update([]);

  var $search = $selection.find('input');
  $search.attr('aria-activedescendant', 'something');

  container.trigger('close');

  assert.ok(
    !$search.attr('aria-activedescendant'),
    'There is no active descendant when the dropdown is closed'
  );
});
=======
module('Accessibility - Search');

var MultipleSelection = require('select2/selection/multiple');
var InlineSearch = require('select2/selection/search');

var $ = require('jquery');

var Utils = require('select2/utils');
var Options = require('select2/options');
var options = new Options({});

test('aria-autocomplete attribute is present', function (assert) {
  var $select = $('#qunit-fixture .multiple');

  var CustomSelection = Utils.Decorate(MultipleSelection, InlineSearch);
  var selection = new CustomSelection($select, options);
  var $selection = selection.render();

  // Update the selection so the search is rendered
  selection.update([]);

  assert.equal(
    $selection.find('input').attr('aria-autocomplete'),
    'list',
    'The search box is marked as autocomplete'
  );
});

test('aria-activedescendant should be removed when closed', function (assert) {
  var $select = $('#qunit-fixture .multiple');

  var CustomSelection = Utils.Decorate(MultipleSelection, InlineSearch);
  var selection = new CustomSelection($select, options);
  var $selection = selection.render();

  var container = new MockContainer();
  selection.bind(container, $('<span></span>'));

  // Update the selection so the search is rendered
  selection.update([]);

  var $search = $selection.find('input');
  $search.attr('aria-activedescendant', 'something');

  container.trigger('close');

  assert.ok(
    !$search.attr('aria-activedescendant'),
    'There is no active descendant when the dropdown is closed'
  );
});
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
