defmodule A do
  def resolve(input) when is_binary(input) do
    input |> resolve({0, 0}, {0, 0}, 1, MapSet.new())
  end

  defp resolve(<<direction, rest::binary>>, {xs, ys}, {xr, yr}, turn, visited) do
    {x, y} =
      case <<direction>> do
        ">" -> {1, 0}
        "<" -> {-1, 0}
        "^" -> {0, -1}
        "v" -> {0, 1}
      end

    {xs, ys, xr, yr} =
      case turn do
        1 -> {xs + x, ys + y, xr, yr}
        -1 -> {xs, ys, xr + x, yr + y}
      end

    house =
      case turn do
        1 -> {xs, ys}
        -1 -> {xr, yr}
      end

    visited = MapSet.put(visited, house)

    resolve(rest, {xs, ys}, {xr, yr}, turn * -1, visited)
  end

  defp resolve(<<>>, _santa, _robot, _turn, visited) do
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
