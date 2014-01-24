module Enumerable
  def split_up(length:, step: length, pad: [])
    cultivate_slice = ->(slice) { (slice + pad).first(length) }
    (each_slice(step).map &cultivate_slice).each { |slice| yield slice if block_given? }
  end
end
