defmodule A do
  def resolve(input) when is_binary(input) do
    input |> resolve({0, 0}, MapSet.new())
  end

  defp resolve(<<direction, rest::binary>>, {x, y}, visited) do
    {x, y} =
      case <<direction>> do
        ">" -> {x + 1, y}
        "<" -> {x - 1, y}
        "^" -> {x, y - 1}
        "v" -> {x, y + 1}
      end

    visited = MapSet.put(visited, {x, y})

    resolve(rest, {x, y}, visited)
  end

  defp resolve(<<>>, {_x, _y}, visited) do
    visited
    |> Enum.uniq()
    |> Enum.count()
  end

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
