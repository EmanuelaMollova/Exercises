(define (mon-seq x)
  (if(< x 10) #t
     (if (<= (remainder x 10) (remainder (quotient x 10) 10)) #f
             (mon-seq (quotient x 10)))))
