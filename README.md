# Memorial Backend

## Makeコマンド

### Setup

- git cloneする
- makeコマンドを使える状態にする
- `make setup`する(完了後はバックエンド起動した状態になっています)

### 起動

- `make up`でバックエンドを起動する

### 終了

- `make down`でバックエンドを終了する
- DBデータ等のボリュームデータ全て消したい場合は`make destroy`する

### マイグレーション

- `make migrate`

### パッケージ追加

#### devDependencies

`make require-dev package=<package name>`

#### dependencies

`make require package=<package name>`
