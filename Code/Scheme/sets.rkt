(define (union list1 list2)
   (cond ((and (null? list1) (null? list2)) ())
         ((null? list1) list2)
         ((null? list2) list1)
         (else (cons(car list1) (union(cdr list1) list2)))))

; help function for intersection and diff
(define (has-element? x list)
  (cond ((null? list) #f)
        (( = x (car list)) #t)
        (else (has-element? x (cdr list)))))

(define (intersection list1 list2)
   (cond ((or (null? list1) (null? list2)) ())
         ((has-element? (car list1) list2)  (cons (car list1)(intersection(cdr list1) list2)))
         (else (intersection (cdr list1) list2)) ))
  
(define (diff list1 list2)
   (cond ((and (null? list1) (null? list2)) ())
         ((null? list1) ())
         ((null? list2) list1)  
         ((has-element? (car list1) list2) (diff (cdr list1) list2))
         (else (cons (car list1) (diff (cdr list1) list2)))))

; help function for remove-dup
(define (remove-digit digit list)
  (cond ((null? list ...))
    (( = (car list) digit) (remove-digit digit (cdr list)))
      (else (cons (car list) (if (null? list) (cons(remove-digit digit (cdr list))))))

      
(define test1 (list 5 7 2))

(define test2 (list 1 2 3 4 4 3))