(define (merge-sort list1 list2)
  (cond ((null? list1) list2)
        ((null? list2) list1)
        ((<= (car list2) (car list1)) (cons (car list2) (merge-sort list1 (cdr list2))))
        ((> (car list2) (car list1)) (cons (car list1) (merge-sort (cdr list1) list2)))))

(define test1 (list 1 2 5 20))

(define test2 (list 0 5 8 30))
