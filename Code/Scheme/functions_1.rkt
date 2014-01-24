; 1
; S(x,n) = sum from k=1 to n of ( (-1)^(k-1) * 2^(4*k-1) * x^(2*k) ) / (2k)!
(define (fact k)
  (if (= k 1) k
  (* k (fact (- k 1)))))

(define (sum-s x n)
  (if (= n 1) (* 4 (* x x))
      (+ (/ (* (expt -1 (- n 1)) (expt 2 (- (* 4 n) 1)) (expt x (* 2 n))) (fact (* 2 n))) (sum-s x (- n 1)))))

; 2
; first derivative of polynomial (coef 1)(deg 1) ... (coef n)(deg n)
(define (derive list1)
  (apply append (map (lambda (x) (if (= (cdr x) 0) `()
                     (list (cons (* (car x) (cdr x)) (- (cdr x) 1))))) list1)))

; 3
; arguments: list l - ((a1 b1)(a2 b2) ... (an bn)), function f
; returns: (f(b1, an) f(b2, a n-1) ... f(bn, a1))

(define (take-b list)
  (map (lambda (x) (cadr x)) list))

(define (take-a list)
  (reverse (map (lambda (x) (car x)) list)))

(define (make-list list1 list2)
  (if (not (null? list1)) (append (list (list (car list1) (car list2))) (make-list (cdr list1) (cdr list2)))
      ()))

(define (func f l)
  (map (lambda (x) (f (car x) (cadr x))) (make-list (take-b l) (take-a l))))

(define (funccc a b)
  (+ a b))

; 4
; arguments: function f, list l of numbers
;returns: function with value in x = f(y), where y = average of the elements of l <= x

(define (bla f l)
  (lambda (x)
    (f (/ (apply + (filter (lambda (y) (if (<= y x) #t #f)) l)) (length (filter (lambda (y) (if (<= y x) #t #f)) l)))) ))

(define (func a)
  (+ a 2))
