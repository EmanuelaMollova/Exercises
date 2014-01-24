class Array
  def to_proc
    ->(object) { map { |element| element.to_proc.call(object) } }
  end
end

class Hash
  def to_proc
    ->(object) do
      each { |key, value| (key.to_s + "=").to_sym.to_proc.call(object, value) }
    end
  end
end
