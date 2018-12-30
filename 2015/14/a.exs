defmodule A do
  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n", trim: true)
    |> Enum.map(&parse_reindeer/1)
  end

  def resolve(input) do
    input
    |> Enum.map(fn {_name, speed, duration, rest} ->
      run(speed, duration, rest, 2503)
    end)
    |> Enum.max()
  end

  defp run(speed, duration, rest, seconds) do
    full = div(seconds, duration + rest) * duration
    partial = min(duration, rem(seconds, duration + rest))
    speed * (full + partial)
  end

  defp parse_reindeer(str) do
    [_, name, speed, duration, rest] =
      Regex.run(
        ~r/(^[A-Za-z]+) can fly ([\d]+) km\/s for ([\d]+) seconds, but then must rest for ([\d]+) seconds/,
        str
      )

    {name, String.to_integer(speed), String.to_integer(duration), String.to_integer(rest)}
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
