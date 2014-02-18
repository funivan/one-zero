/**
 * @author Ivan Shcherbak <dev@funivan.com> 2/17/14
 */
oneZero = function () {

  var prepareNode = function (node) {
    if (!node.myData) {
      node.myData = {};
    }
    if (node.myData['data-node-real-text']) {
      node.nodeValue = node.myData['data-node-real-text'];
      node.myData['data-node-real-text'] = false;
    } else {

      var textArray = node.nodeValue.split('');
      var letterIndex;
      for (letterIndex in textArray) {
        var charCode = textArray[letterIndex].charCodeAt(0);

        if (
          (charCode <= 64)
            || (charCode >= 91 && charCode <= 96)
            || (charCode >= 123 && charCode <= 191)
            || (charCode >= 8592 && charCode <= 8660 )
            || (charCode >= 8194 && charCode <= 8260 )
          ) {
          continue;
        }
        if (charCode % 2) {
          textArray[letterIndex] = '1';
        } else {
          textArray[letterIndex] = '0';
        }
      }
      node.myData['data-node-real-text'] = node.nodeValue;
      node.nodeValue = textArray.join('');
    }
  };

  this.run = function (baseNode) {
    if (typeof baseNode == 'undefined') {
      baseNode = document.body;
    }
    var walker = document.createTreeWalker(baseNode, NodeFilter.SHOW_TEXT, null, false);
    var node;
    while (node = walker.nextNode()) {
      prepareNode(node);
    }
  };
};
