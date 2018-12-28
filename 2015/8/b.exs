defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
  end

  def resolve(input) do
    input
    |> Enum.map(fn x -> String.length(encode(x)) - String.length(x) + 2 end)
    |> Enum.sum()
  end

  def decode(str) do
    str
    |> String.replace(~r/\\((x..)|([\\,\"]))/, "A")
  end

  def encode(str) do
    str
    |> String.replace("\\", "\\\\")
    |> String.replace("\"", "\\\"")
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
