defmodule Day7 do
  use Bitwise

  def resolve(input) do
    input
    |> resolve("a")
    |> elem(0)
  end

  def resolve(input, key) when is_integer(key) do
    {key, input}
  end

  def resolve(input, key) when is_binary(key) do
    {return, input} = resolve(input, Map.get(input, key))
    input = Map.put(input, key, return)
    {return, input}
  end

  def resolve(input, {"NOT", key}) do
    {value, input} = resolve(input, key)
    {~~~value, input}
  end

  def resolve(input, {op, key1, key2}) do
    {value1, input} = resolve(input, key1)
    {value2, input} = resolve(input, key2)

    return =
      case op do
        "OR" -> value1 ||| value2
        "AND" -> value1 &&& value2
        "LSHIFT" -> value1 <<< value2
        "RSHIFT" -> value1 >>> value2
      end

    {return, input}
  end

  defp mto_integer(str) do
    case Integer.parse(str) do
      :error -> str
      {n, _} -> n
    end
  end

  defp parse_line(line) do
    [value, key] = String.split(line, " -> ")

    value =
      case String.split(value, " ") do
        [key] -> mto_integer(key)
        ["NOT", key] -> {"NOT", mto_integer(key)}
        [key1, op, key2] -> {op, mto_integer(key1), mto_integer(key2)}
      end

    {key, value}
  end

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
    |> String.split("\n")
    |> Enum.map(&parse_line(&1))
    |> Enum.reduce(%{}, fn {k, v}, acc -> Map.put(acc, k, v) end)
  end
end
