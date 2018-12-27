defmodule A do
  def resolve(input) when is_binary(input),
    do: input |> resolve(0, 0)

  defp resolve(_input, -1, count), do: count

  defp resolve(<<"(", rest::binary>>, floor, count),
    do: resolve(rest, floor + 1, count + 1)

  defp resolve(<<")", rest::binary>>, floor, count),
    do: resolve(rest, floor - 1, count + 1)

  def create_input(filename) when is_binary(filename),
    do: File.read!(filename) |> String.trim()
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
