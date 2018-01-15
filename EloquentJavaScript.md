### [Eloquent JavaScript](http://eloquentjavascript.net/)

Chapter 1 (Values, Types, and Operators)
----------------------------------------

* six basic types of values in JavaScript: numbers (64 bits), strings, Booleans, objects, functions, and undefined
* % - reminder
* Infinity, - Infinity, NaN (0 / 0, Infinity - Infinity...)
* typeof (typeof 4.5, typeof "x")
* console.log(NaN == NaN) // → false
* null and undefined
* 0, NaN, and the empty string ("") count as false, while all the other values count as true

```javascript
console.log(8 * null)
// → 0
console.log("5" - 1)
// → 4
console.log("5" + 1)
// → 51
console.log("five" * 2)
// → NaN
console.log(false == 0)
// → true
console.log(null == undefined);
// → true
console.log(null == 0);
// → false
```
