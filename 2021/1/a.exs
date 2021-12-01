defmodule A do
  def resolve([head | tail]) do
    resolve(tail, head, 0)
  end

  defp resolve([head | tail], last, count) do
    count =
      if head > last do
        count + 1
      else
        count
      end

    resolve(tail, head, count)
  end

  defp resolve([], _last, count) do
    count
  end
end

defmodule B do
  def resolve([a, b, c | tail]) do
    resolve([b, c | tail], a + b + c, 0)
  end

  defp resolve([a, b, c | tail], last, count) do
    count =
      if a + b + c > last do
        count + 1
      else
        count
      end

    resolve([b, c | tail], a + b + c, count)
  end

  defp resolve(_, _last, count) do
    count
  end
end

input =
  File.read!('./input')
  |> String.split("\n", trim: true)
  |> Enum.map(&String.to_integer/1)

input
|> A.resolve()
|> IO.puts()

input
|> B.resolve()
|> IO.puts()
