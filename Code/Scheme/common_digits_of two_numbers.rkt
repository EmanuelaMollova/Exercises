(define (has-digit? digit number)
  (if (= (remainder number 10) digit) 1
      (if (< number 10) 0 (has-digit? digit (quotient number 10)))))

(define (count-similar digit number)
  (if  (= number 0) 0
       (+ (count-similar digit (quotient number 10))
         (if (= digit (remainder number 10)) 1 0))))

(define (to-remove i number result)
  (if (> i 9) result
      (if  (= (has-digit? i number) 1) (to-remove (+ 1 i) number (+ result (- 1 (count-similar i number))))
      (to-remove (+ 1 i) number result))))

(define (common-duplicate x y)
  (if (< x 10) (has-digit? x y)
      (+ (has-digit? (remainder x 10) y) (common-duplicate (quotient x 10) y)) ))

(define (common x y)
  (+ (common-duplicate x y) (to-remove 1 x 0)))
