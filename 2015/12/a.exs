defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
  end

  def resolve(input) do
    Regex.scan(~r/[\d-]+/, input)
    |> List.flatten
    |> Enum.map(&String.to_integer/1)
    |> Enum.sum
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
