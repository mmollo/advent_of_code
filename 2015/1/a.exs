defmodule A do
  def resolve(input) when is_binary(input) do
    input |> resolve(0)
  end

  defp resolve(<<"(", rest::binary>>, floor),
    do: resolve(rest, floor + 1)

  defp resolve(<<")", rest::binary>>, floor),
    do: resolve(rest, floor - 1)

  defp resolve(<<>>, floor), do: floor

  def create_input(filename) when is_binary(filename) do
    File.read!(filename) |> String.trim()
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
