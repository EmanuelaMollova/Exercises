class Object
  def thread(*args)
    args.reduce(self) { |reduced, arg| arg.to_proc.call reduced }
  end
end
