input =
  File.read!("input")
  |> String.trim()

# input = "dabAcCaCBAcCcaDA"
defmodule A do
  # My very slow and inefficient solution, don't try to run it
  def resolve(input) do
    resolve(input, 0)
  end

  defp resolve(input, start) do
    start =
      if start < 0 do
        0
      else
        start
      end

    if start == String.length(input) - 1 do
      String.length(input)
    else
      <<a, b>> = String.slice(input, start, 2)

      case abs(a - b) do
        32 ->
          resolve(
            String.slice(input, 0, start) <> String.slice(input, (start + 2)..-1),
            start - 1
          )

        _ ->
          resolve(input, start + 1)
      end
    end
  end

  # © José Valim
  # I just love how elegant and fast it is
  def react(polymer) when is_binary(polymer),
    do: react(polymer, [])

  def react(<<letter1, rest::binary>>, [letter2 | acc]) when abs(letter1 - letter2) == 32,
    do: react(rest, acc)

  def react(<<letter, rest::binary>>, acc),
    do: react(rest, [letter | acc])

  def react(<<>>, acc),
    do: acc |> Enum.count()
end

input
|> A.resolve()
|> IO.inspect()
