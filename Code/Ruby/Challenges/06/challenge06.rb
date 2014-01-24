class Polynomial
  attr_accessor :coefficients

  def initialize(coefficients)
    if coefficients.size == 0 or coefficients.nil? or not coefficients.kind_of?(Array)
      raise "Invalid coefficients."
    end
    @coefficients = coefficients
  end

  def to_s
    count = @coefficients.size
    polynomial = @coefficients.map.with_index do |coefficient, index|
      unless coefficient.zero?
        (coefficient < 0 ? ' - ' : ' + ') +
        ((coefficient.abs.equal? 1 and index != count - 1) ? '' : "#{coefficient.abs}") +
        ((count - index - 1).zero? ? '' : 'x') +
        ((count - index - 1) < 2 ? '' : "^#{count - index - 1}")
      end
    end.compact.join('')[1..-1]
    !polynomial ? '0' : (polynomial[0,1] == '+' ? polynomial[2..-1] : polynomial)
  end
end
