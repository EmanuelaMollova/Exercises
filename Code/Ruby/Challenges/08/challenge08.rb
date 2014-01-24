class Spy < BasicObject
  attr_reader :calls

  def initialize(instance)
    @instance = instance
    @calls = []
  end

  def method_missing(method_name, *args, &block)
    if @instance.respond_to? method_name
      @calls <<  method_name
      @instance.send method_name, *args, &block
    else
      ::Kernel::raise Error
    end
  end

  class Error < ::NoMethodError
  end
end
