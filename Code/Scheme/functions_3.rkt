; 1
(define (divs n)
  (define (helper number del result)
    (cond ((= 0 del) result)
          ((= (remainder number del) 0) (helper number (- del 1) (cons del result)))
          (else (helper number (- del 1) result))))
  (helper n (- n 1) `()))

(define (intersection l1 l2)
  (filter (lambda (x) (if (member x l2) #t #f)) l1))

(define (len-int num1 num2 k)
  (if (>= (length (intersection (divs num1) (divs num2))) k) #t #f))

(define (n-similar l n)
  (filter (lambda (x) (len-int (car x) (cadr x) n)) l))

; 2
(define (sumpair f g n)
  (define (helper f g n i res)
    (if (> i n) res
        (helper f g n (+ i 1) (+ res (f i (g i))))))
  (helper f g n 1 0))

(define (func-f a b)
  (+ a b))

(define (func-g a)
  a)

; 3
(define (remove-digit digit list1)
  (cond ((null? list1) `())
        ((= (car list1) digit) (remove-digit digit (cdr list1)))
        (else (cons (car list1) (remove-digit digit (cdr list1))))))

(define (unique l)
  (cond ((null? l) `())
        ((member (car l) (cdr l)) (unique (remove-digit (car l) l)))
        (else (cons (car l) (unique (cdr l))))))

; 4
(define (has-del digit list1)
  (cond ((null? list1) #f)
        ((= (remainder digit (car list1)) 0) #t)
        (else (has-del digit (cdr list1)))))

(define (one-way-divisor-helper list1)
  (cond ((null? list1) #t)
        ((equal? (car list1) #f) #f)
        (else (one-way-divisor-helper (cdr list1)))))

(define (one-way-divisor list1 list2)
  (one-way-divisor-helper (map (lambda (x) (has-del x list2)) list1)))

(define (list-divisor? l1 l2)
  (if (and (one-way-divisor l1 l2) (one-way-divisor l2 l1)) #t #f))
