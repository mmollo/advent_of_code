defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
  end

  def resolve(input) do
    input
    |> Enum.map(fn x -> String.length(x) - String.length(decode(x)) + 2 end)
    |> Enum.sum()
  end

  def memory_size(str) do
    (str |> decode |> String.length()) - 2
  end

  def decode(str) do
    str
    |> String.replace(~r/\\((x..)|([\\,\"]))/, "A")
  end

  def encode(str) do
    IO.puts(str)

    str
    |> String.replace("\\", "\\\\")
    |> String.replace("\"", "\\\"")
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
