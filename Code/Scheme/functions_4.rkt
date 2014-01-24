(define (hasDigit x y)
  (cond ((and (< x 10) (= x y)) #t)
        ((and (< x 10) (not (= x y))) #f)
        ((= (remainder x 10) y) #t)
        ((not (= (remainder x 10) y)) (hasDigit (quotient x 10) y))))

(define (ints n)
  (cons-stream n (ints(+ n 1))))

(define (numbersWithout d)
  (filter (lambda (x) (if (hasDigit x d) #t #f)) (ints 1)))
