input =
  File.read!("input")
  |> String.split(["\r", "\n"], trim: true)

defmodule B do
  def dist(first, second) do
    len = String.length(first) - 1

    for(x <- 0..len, String.at(first, x) != String.at(second, x), do: true)
    |> Enum.count()
  end

  def common(first, second) do
    len = String.length(first) - 1

    for(x <- 0..len, String.at(first, x) == String.at(second, x), do: String.at(first, x))
    |> Enum.join("")
  end
end

count = Enum.count(input) - 1

for(
  a <- 0..count,
  b <- 1..count,
  a < b,
  first = Enum.at(input, a),
  second = Enum.at(input, b),
  1 == B.dist(first, second),
  do: B.common(first, second)
)
|> Enum.at(0)
|> IO.inspect()
