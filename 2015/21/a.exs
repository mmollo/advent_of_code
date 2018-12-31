defmodule Fighter do
  defstruct name: "", hp: 100, damage: 0, armor: 0
end

defmodule A do
  @weapons [
    {:Dagger, 8, 4, 0},
    {:Shortsword, 10, 5, 0},
    {:Warhammer, 25, 6, 0},
    {:Longsword, 40, 7, 0},
    {:Greataxe, 74, 8, 0}
  ]

  @armor [
    {:Leather, 13, 0, 1},
    {:Chainmail, 31, 0, 2},
    {:Splintmail, 53, 0, 3},
    {:Bandedmail, 75, 0, 4},
    {:Platemail, 102, 0, 5},
    {:none, 0, 0, 0}
  ]

  @rings [
    {:Damage1, 25, 1, 0},
    {:Damage2, 50, 2, 0},
    {:Damage3, 100, 3, 0},
    {:Defense1, 20, 0, 1},
    {:Defense2, 40, 0, 2},
    {:Defense3, 80, 0, 3}
  ]

  def resolve do
    rings2 =
      for(r1 <- @rings, r2 <- @rings, r1 != r2, do: [r1, r2])
      |> Enum.map(&Enum.sort/1)
      |> Enum.uniq()

    rings1 = for r <- @rings, do: [r]
    rings = rings2 ++ rings1 ++ [[{:none, 0, 0, 0}]]

    boss = %Fighter{name: "Boss", hp: 104, damage: 8, armor: 1}

    for(w <- @weapons, a <- @armor, r <- rings, do: [w, a | r])
    |> Enum.map(&equipement/1)
    |> Enum.map(fn {_items, {cost, damage, armor}} ->
      {cost, fight(%Fighter{name: "Player", hp: 100, damage: damage, armor: armor}, boss)}
    end)
    |> Enum.filter(fn {_cost, name} -> name == "Player" end)
    |> Enum.sort()
    |> Enum.at(0)
    |> elem(0)
  end

  defp equipement(items) when is_list(items) do
    Enum.reduce(items, {[], {0, 0, 0}}, fn {name, c, d, a}, {names, {tc, td, ta}} ->
      {[name | names], {tc + c, td + d, ta + a}}
    end)
  end

  def fight(attacker, defender) do
    defender = %{defender | hp: damage(defender.hp, attacker.damage, defender.armor)}

    case defender.hp == 0 do
      true -> attacker.name
      false -> fight(defender, attacker)
    end
  end

  def damage(hp, damage, armor) do
    max(0, hp - max(damage - armor, 1))
  end
end

A.resolve()
# A.damage(104, 10, 3)
|> IO.inspect()
