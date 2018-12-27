defmodule A do
  def resolve(input) do
    input |> resolve(0)
  end

  defp resolve(key, salt) do
    hash = :crypto.hash(:md5, key <> to_string(salt))
    |> Base.encode16

    case String.slice(hash, 0, 6) do
      "000000" -> salt
      _ -> resolve(key, salt+1)
    end
    
  end

  def create_input(filename) when is_binary(filename) do
    File.read!(filename)
    |> String.trim()
  end
end

A.create_input("input")
|> A.resolve()
|> IO.inspect()
