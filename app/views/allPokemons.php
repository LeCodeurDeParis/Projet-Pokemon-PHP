<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisissez votre Pokémon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Ajout de la police Pixelify Sans -->
    <style>
        @font-face {
            font-family: 'Pixelify Sans';
            src: url('/app/assets/fonts/PixelifySans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @layer utilities {
            .font-pixelify {
                font-family: 'Pixelify Sans', sans-serif;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col  font-pixelify">
    <header>
        <div class="h-32 bg-gradient-to-b from-[#B22222] via-[#4B4B4B] to-[#1C1C1C]">
            <!-- Ajout du logo Pokémon -->
            <img src="/app/assets/Logo-Pokemon.png" alt="Logo Pokémon" class="h-full mx-auto">
        </div>
    </header>
    <main class="flex-grow">
        <h1 class="text-xl flex self-center p-4">Choisissez votre Pokémon</h1>
            <form action="/Combat/demarrerCombat" method="POST">
                <label for="pokemon" class="text-xl flex self-center p-4">Sélectionnez un Pokémon :</label>
                    <div class="flex justify-evenly mt-8">
                        <!-- Affichage des Pokémon disponibles -->
                        <?php foreach ($pokemons as $pokemon): ?>
                            <!-- Affichage des Pokémon en fonction de leur type -->
                            <?php switch ($pokemon['type']) {
                                case 'Feu':
                                    ?>
                                    <div class="flex w-64 h-auto flex-col items-center bg-gradient-to-b from-[#F81900] to-[#4C2E2E] text-white gap-4 border-2 rounded-xl border-black">
                                        <div class="flex items-center justify-center w-20 h-[20%] m-4">
                                            <img src="/app/assets/sprites/Sprite_<?= $pokemon['nom'] ?>.png" alt="<?= $pokemon['nom'] ?>" class="object-cover self-center">
                                        </div>
                                        <p>Nom: <?= $pokemon['nom'] ?></p>
                                        <p>Type: <?= $pokemon['type'] ?></p>
                                        <p>PV: <?= $pokemon['pointsDeVie'] ?> </p>
                                        <p>Attaque: <?= $pokemon['puissanceAttaque'] ?></p>
                                        <p>Défense: <?= $pokemon['defense'] ?> </p>
                                        <button type="submit" name="pokemon_id" value="<?= $pokemon['id'] ?>">Commencer le combat</button>
                                    </div>
                                    <?php
                                    break;
                                case 'Eau':
                                    ?>
                                    <div class="flex w-64 h-auto flex-col items-center bg-gradient-to-b from-[#6890F0] to-[#4C2E2E] text-white gap-4 border-2 rounded-xl border-black">
                                        <div class="flex items-center justify-center w-20 h-[20%] m-4">
                                            <img src="/app/assets/sprites/Sprite_<?= $pokemon['nom'] ?>.png" alt="<?= $pokemon['nom'] ?>" class="object-cover self-center">
                                        </div>
                                        <p>Nom: <?= $pokemon['nom'] ?></p>
                                        <p>Type: <?= $pokemon['type'] ?></p>
                                        <p>PV: <?= $pokemon['pointsDeVie'] ?> </p>
                                        <p>Attaque: <?= $pokemon['puissanceAttaque'] ?></p>
                                        <p>Défense: <?= $pokemon['defense'] ?> </p>
                                        <button type="submit" name="pokemon_id" value="<?= $pokemon['id'] ?>">Commencer le combat</button>  
                                    </div>
                                    <?php
                                    break;
                                case 'Plante':
                                    ?>
                                    <div class="flex w-64 h-auto flex-col items-center text-white gap-4 bg-gradient-to-b from-[#78C850] to-[#4C2E2E] border-2 rounded-xl border-black">
                                        <div class="flex items-center justify-center w-20 h-[20%] m-4">
                                            <img src="/app/assets/sprites/Sprite_<?= $pokemon['nom'] ?>.png" alt="<?= $pokemon['nom'] ?>" class="object-cover self-center">
                                        </div>
                                        <p>Nom: <?= $pokemon['nom'] ?></p>
                                        <p>Type: <?= $pokemon['type'] ?></p>
                                        <p>PV: <?= $pokemon['pointsDeVie'] ?> </p>
                                        <p>Attaque: <?= $pokemon['puissanceAttaque'] ?></p>
                                        <p>Défense: <?= $pokemon['defense'] ?> </p>
                                        <button type="submit" name="pokemon_id" value="<?= $pokemon['id'] ?>">Commencer le combat</button>
                                    </div>
                                    <?php
                                    break;
                                default:
                                    ?>
                                    <div class="flex w-32 flex-col items-center bg-green-500">
                                        <img src="/app/assets/sprites/Sprite_<?= $pokemon['nom'] ?>.png" alt="<?= $pokemon['nom'] ?>" class="h-[30%]">
                                        <p>Nom: <?= $pokemon['nom'] ?></p>
                                        <p>Type: <?= $pokemon['type'] ?></p>
                                        <p>PV: <?= $pokemon['pointsDeVie'] ?> </p>
                                        <p>Attaque :<?= $pokemon['puissanceAttaque'] ?></p>
                                        <p>Défense :<?= $pokemon['defense'] ?> </p>
                                    </div>
                                    <?php
                            } ?>
                        <?php endforeach; ?>
                    </div>     
            </form>
    </main>
    <footer>
        <div class="h-24 bg-gradient-to-t from-[#B22222] via-[#4B4B4B] to-[#1C1C1C] flex justify-center items-center text-xl">
            <p class="text-white text-center">Paul Boisaubert-Baillion</p>
        </div>
    </footer>
</body>
</html>