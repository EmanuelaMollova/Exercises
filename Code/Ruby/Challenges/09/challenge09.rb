class Memoizer < BasicObject
  def initialize(target)
    @target = target
    @cache = {}
  end

  def method_missing(method_name, *args, &block)
    if @target.respond_to? method_name
      return @cache[method_name, *args] if @cache.key? [method_name, *args]
      value = @target.public_send method_name, *args, &block
      block.nil? ? @cache[method_name, *args] = value : value
    else
      ::Kernel.raise ::NoMethodError
    end
  end
end
